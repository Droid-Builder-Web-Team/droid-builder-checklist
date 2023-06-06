<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Middleware;
use Silber\Bouncer\Bouncer;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
//    public function share(Request $request): array
//    {
//        return array_merge(parent::share($request), [
//            'auth' => [
//                'user' => $request->user(),
//            ],
//            'ziggy' => function () use ($request) {
//                return array_merge((new Ziggy)->toArray(), [
//                    'location' => $request->url(),
//                ]);
//            },
//        ]);
//    }

    public function share(Request $request): array
    {
        $sharedData = parent::share($request);

        $user = $request->user();
        $bouncer = app(Bouncer::class);
        $roleId = DB::table('assigned_roles')
            ->where('entity_id', $user->id)
            ->value('role_id');

        $role = $bouncer->role()->where('id', $roleId)->first();

        $sharedData['auth']['user'] = [
            'id' => optional($user)->id,
            'name' => optional($user)->name,
            'email' => optional($user)->email,
            'role' => $role,
        ];

        $sharedData['ziggy'] = function () use ($request) {
            return array_merge((new Ziggy)->toArray(), [
                'location' => $request->url(),
            ]);
        };

        return $sharedData;
    }
}
