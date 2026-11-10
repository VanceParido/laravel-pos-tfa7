<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Exceptions\DecoderException;
use Intervention\Image\ImageManager;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->get();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username'),
            ],
            'full_name' => ['required', 'string', 'max:255'],
        ]);

        User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user),
            ],
            'full_name' => ['required', 'string', 'max:255'],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
                'dimensions:max_width=4096,max_height=4096',
            ],
        ]);

        $data = [
            'username' => $validated['username'],
            'full_name' => $validated['full_name'],
        ];

        $newAvatarPath = null;
        $oldAvatarPath = $user->avatar;

        if ($request->hasFile('avatar')) {
            $manager = new ImageManager(new Driver());

            try {
                $image = $manager
                    ->read($request->file('avatar')->getRealPath())
                    ->cover(200, 200)
                    ->toJpeg(85);
            } catch (DecoderException $exception) {
                throw ValidationException::withMessages([
                    'avatar' => 'This image could not be read. Try another image.',
                ]);
            }

            $newAvatarPath = 'avatars/' . Str::uuid() . '.jpg';

            $saved = Storage::disk('public')->put(
                $newAvatarPath,
                (string) $image
            );

            if (! $saved) {
                throw ValidationException::withMessages([
                    'avatar' => 'The image could not be saved. Please try again.',
                ]);
            }

            $data['avatar'] = $newAvatarPath;
        }

        try {
            $user->update($data);
        } catch (\Throwable $exception) {
            if ($newAvatarPath !== null) {
                Storage::disk('public')->delete($newAvatarPath);
            }

            throw $exception;
        }

        if ($newAvatarPath !== null && $oldAvatarPath) {
            Storage::disk('public')->delete($oldAvatarPath);
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully.');
    }
}