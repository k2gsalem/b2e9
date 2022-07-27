<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>
    <link rel="icon" type="image/png" href="{{ asset("img/favicon.png") }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        .table th:first-child {
            position: inherit;
        }
    </style>
    @stack('styles')

    @livewireStyles
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
</head>
<body>
<div class="drawer drawer-mobile min-h-screen bg-gray-100">
    <input id="my-drawer-2" type="checkbox" class="drawer-toggle">
    <div class="drawer-side justify-start">
        <label for="my-drawer-2" class="drawer-overlay"></label>
        <div class="flex grow flex-col gap-2 py-2 h-full bg-base-100 text-base-content w-72">
            <div class="px-2">
                <img src="{{ asset('img/logo.png') }}" class="h-10" />
            </div>
            <ul class="menu overflow-y-auto grow">
                <li class="hover:bordered {{ request()->routeIs('admin.dashboard') ? 'active bordered' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        Dashboard
                    </a>
                </li>
                @if(auth()->id() == 1)
                    <li class="hover:bordered {{ request()->routeIs('admin.admins.index') ? 'active bordered' : '' }}">
                        <a href="{{ route('admin.admins.index') }}">
                            Manage Staffs
                        </a>
                    </li>
                @endif
                @can('users.list')
                    <li class="hover:bordered {{ request()->routeIs('admin.users.index') ? 'active bordered' : '' }}">
                        <a href="{{ route('admin.users.index') }}">
                            Manage Users
                        </a>
                    </li>
                @endcan
                @can('projects.list')
                    <li class="hover:bordered {{ request()->routeIs('admin.projects.index') ? 'active bordered' : '' }}">
                        <a href="{{ route('admin.projects.index') }}">
                            Manage Projects
                        </a>
                    </li>
                @endcan
                @can('materials.list')
                    <li class="hover:bordered {{ request()->routeIs('admin.materials.index') ? 'active bordered' : '' }}">
                        <a href="{{ route('admin.materials.index') }}">
                            Materials
                        </a>
                    </li>
                @endcan
                @can('processes.list')
                    <li class="hover:bordered {{ request()->routeIs('admin.processes.index') ? 'active bordered' : '' }}">
                        <a href="{{ route('admin.processes.index') }}">
                            Processes
                        </a>
                    </li>
                @endcan
                @can('locations.list')
                    <li class="hover:bordered {{ request()->routeIs('admin.locations.index') ? 'active bordered' : '' }}">
                        <a href="{{ route('admin.locations.index') }}">
                            Locations
                        </a>
                    </li>
                @endcan
                @can('blog.list')
                    <li class="hover:bordered {{ request()->routeIs('admin.posts.index') ? 'active bordered' : '' }}">
                        <a href="{{ route('admin.posts.index') }}">
                            Blog
                        </a>
                    </li>
                @endcan
                @canany(['reports.project_transactions', 'reports.subscriptions'])
                    <li x-data="{ open: {{ request()->routeIs('admin.reports.*') ? 'true' : 'false' }} }"
                        class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <a href="#" @click.prevent="open = !open" class="flex justify-between">
                            <span>Reports</span>
                            <svg x-cloak x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <svg x-cloak x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </a>
                        <ul x-cloak x-show="open" class="menu">
                            @can('reports.project_transactions')
                                <li class="{{ request()->routeIs('admin.reports.project-transactions') ? 'active' : '' }}">
                                    <a href="{{ route('admin.reports.project-transactions') }}">Project Transactions</a>
                                </li>
                            @endcan
                            @can('reports.subscriptions')
                                <li class="{{ request()->routeIs('admin.reports.subscriptions') ? 'active' : '' }}">
                                    <a href="{{ route('admin.reports.subscriptions') }}">Subscriptions</a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcanany
                @can('membership_plans.list')
                    <li class="hover:bordered {{ request()->routeIs('admin.plans.index') ? 'active bordered' : '' }}">
                        <a href="{{ route('admin.plans.index') }}">
                            Membership Plans
                        </a>
                    </li>
                @endcan
                @can('rfq_packages.list')
                    <li class="hover:bordered {{ request()->routeIs('admin.packages.index') ? 'active bordered' : '' }}">
                        <a href="{{ route('admin.packages.index') }}">
                            RFQ Packages
                        </a>
                    </li>
                @endcan
                @can('website_settings')
                    <li class="hover:bordered {{ request()->routeIs('admin.website_settings.index') ? 'active bordered' : '' }}">
                        <a href="{{ route('admin.website_settings.index') }}">
                            Website Settings
                        </a>
                    </li>
                @endcan
                @can('newsletter.list')
                    <li class="hover:bordered {{ request()->routeIs('admin.newsletter') ? 'active bordered' : '' }}">
                        <a href="{{ route('admin.newsletter') }}">
                            Newsletter
                        </a>
                    </li>
                @endcan
                @can('support')
                    <li class="hover:bordered {{ request()->routeIs('admin.support.index') ? 'active bordered' : '' }}">
                        <a href="{{ route('admin.support.index') }}">
                            Support Page
                        </a>
                    </li>
                @endcan
            </ul>
            <ul class="menu p-4 overflow-y-auto">
                <li>
                    <a href="{{ route('admin.logout') }}">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="drawer-content">
        {{ $slot }}
    </div>
</div>
<x-loading />

@stack('modals')

@livewireScripts
{{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />

@stack('scripts')
</body>
</html>
