@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Profile</h1>
            <p class="mt-2 text-gray-600">Manage your personal information and preferences</p>
        </div>

        <!-- Profile Card -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6 sm:pb-8">
                <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-5">
                    <div class="flex-shrink-0">
                        <img class="mx-auto h-20 w-20 rounded-full" src="{{ Auth::user()->profile_photo ?? asset('images/default-avatar.png') }}" alt="{{ Auth::user()->name }}">
                    </div>
                    <div class="mt-4 sm:mt-0 sm:flex-1">
                        <h3 class="text-lg font-medium text-gray-900">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                        <div class="mt-2 flex items-center">
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000-16zm3.707-9.293a1 1 0 00-1.414-1.414 1 1 0 001.414 1.414l-.707.707a1 1 0 00-.004-.002V8.5a.5.5 0 00-.5-.5V4.5a.5.5 0 00-.5-.5z" />
                                </svg>
                                Active
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 pt-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Role</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->role ?? 'Administrator' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Department</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->department ?? 'Human Resources' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->phone ?? '+255 123 456 789' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Location</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->location ?? 'Dar es Salaam, Tanzania' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-6 border-t border-gray-200 pt-6">
                    <div class="flex justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Account Settings</h3>
                        <button class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Edit Profile
                        </button>
                    </div>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Email Notifications</h4>
                                <p class="text-sm text-gray-500">Receive email updates about your account</p>
                            </div>
                            <button class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-gray-200 rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="translate-x-0 inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Two-Factor Authentication</h4>
                                <p class="text-sm text-gray-500">Add an extra layer of security to your account</p>
                            </div>
                            <button class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                Enable
                            </button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">Language</h4>
                                <p class="text-sm text-gray-500">Choose your preferred language</p>
                            </div>
                            <select class="text-sm border-gray-300 rounded-md">
                                <option>English</option>
                                <option>Swahili</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
