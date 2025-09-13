<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LeadsController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name'   => ['nullable', 'string', 'max:256'],
            'last_name'    => ['nullable', 'string', 'max:256'],
            'email'        => ['required', 'email', 'max:256'],
            'country'      => ['nullable', 'string', 'max:256'],
            'phone_prefix' => ['nullable', 'string', 'max:64'],
            'phone_number' => ['nullable', 'string', 'max:64'],
            'password'     => ['nullable', 'string', 'max:255'],
        ]);

        $passwordEncrypted = null;
        if (!empty($validated['password'])) {
            $passwordEncrypted = Crypt::encryptString($validated['password']);
        }

        $lead = Lead::create([
            'first_name'        => $validated['first_name'] ?? null,
            'last_name'         => $validated['last_name'] ?? null,
            'email'             => $validated['email'],
            'country'           => $validated['country'] ?? null,
            'phone_prefix'      => $validated['phone_prefix'] ?? null,
            'phone_number'      => $validated['phone_number'] ?? null,
            'password_encrypted'=> $passwordEncrypted,
            'status'            => 'new',
        ]);

        // Create or find a matching user account for public dashboard access
        $user = User::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name' => trim(($validated['first_name'] ?? '') . ' ' . ($validated['last_name'] ?? '')) ?: $validated['email'],
                'password' => $validated['password'] ?? Str::random(12),
                'is_admin' => false,
            ]
        );

        // If user existed and a new password was provided, optionally update it
        if (!empty($validated['password']) && $user->wasRecentlyCreated === false) {
            $user->password = $validated['password'];
            $user->save();
        }

        // Log the user in and redirect to dashboard
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Thanks! Your account was created and you are now signed in.');
    }

    public function exportCsv(): StreamedResponse
    {
        // Ensure only admins can export
        abort_unless(Auth::check() && (Auth::user()->is_admin ?? false), 403);

        $fileName = 'leads-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Cache-Control' => 'no-store, no-cache',
        ];

        return response()->stream(function () {
            $handle = fopen('php://output', 'w');

            // CSV header
            fputcsv($handle, [
                'ID', 'First Name', 'Last Name', 'Email', 'Country',
                'Phone Prefix', 'Phone Number', 'Status', 'Created At',
            ]);

            Lead::orderBy('id')->chunk(500, function ($chunk) use ($handle) {
                foreach ($chunk as $lead) {
                    fputcsv($handle, [
                        $lead->id,
                        $lead->first_name,
                        $lead->last_name,
                        $lead->email,
                        $lead->country,
                        $lead->phone_prefix,
                        $lead->phone_number,
                        $lead->status,
                        optional($lead->created_at)->toDateTimeString(),
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }
}
