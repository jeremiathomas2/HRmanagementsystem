@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
            <p class="mt-2 text-gray-600">Manage your application settings and preferences</p>
        </div>

        <!-- Settings Tabs -->
        <div class="bg-white shadow rounded-lg">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        General
                    </button>
                    <button class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Security
                    </button>
                    <button class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Notifications
                    </button>
                    <button class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Appearance
                    </button>
                </nav>
            </div>

            <div class="p-6">
                <!-- General Settings -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">General Settings</h3>
                        <p class="mt-1 text-sm text-gray-500">These settings apply to your account across all devices.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                        <div>
                            <label for="company-name" class="block text-sm font-medium text-gray-700">Company Name</label>
                            <input type="text" id="company-name" name="company_name" value="{{ config('app.name', 'HR Management System') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700">Timezone</label>
                            <select id="timezone" name="timezone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option>UTC+03:00 East Africa Time</option>
                                <option>UTC+00:00 Greenwich Mean Time</option>
                                <option>UTC+01:00 Central European Time</option>
                                <option>UTC-05:00 Eastern Time</option>
                            </select>
                        </div>

                        <div>
                            <label for="language" class="block text-sm font-medium text-gray-700">Language</label>
                            <select id="language" name="language" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option>English</option>
                                <option>Swahili</option>
                            </select>
                        </div>

                        <div>
                            <label for="date-format" class="block text-sm font-medium text-gray-700">Date Format</label>
                            <select id="date-format" name="date_format" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option>MM/DD/YYYY</option>
                                <option>DD/MM/YYYY</option>
                                <option>YYYY-MM-DD</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-6">
                        <div class="flex justify-end">
                            <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </button>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="space-y-6 mt-8 pt-8 border-t border-gray-200">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Security Settings</h3>
                        <p class="mt-1 text-sm text-gray-500">Manage your account security and authentication preferences.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">Two-Factor Authentication</h4>
                                <p class="text-sm text-gray-500">Add an extra layer of security to your account</p>
                            </div>
                            <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">
                                Enable
                            </button>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">Password Requirements</h4>
                                <p class="text-sm text-gray-500">Minimum 8 characters, include uppercase, lowercase, and numbers</p>
                            </div>
                            <span class="text-sm text-green-600">Enabled</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">Session Timeout</h4>
                                <p class="text-sm text-gray-500">Automatically log out after 5 minutes of inactivity</p>
                            </div>
                            <span class="text-sm text-gray-600">5 minutes</span>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="space-y-6 mt-8 pt-8 border-t border-gray-200">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Notification Preferences</h3>
                        <p class="mt-1 text-sm text-gray-500">Choose how you want to receive notifications.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">Email Notifications</h4>
                                <p class="text-sm text-gray-500">Receive email updates about your account activity</p>
                            </div>
                            <button class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-gray-200 rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 bg-indigo-600">
                                <span class="translate-x-5 inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                            </button>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">Push Notifications</h4>
                                <p class="text-sm text-gray-500">Receive push notifications in your browser</p>
                            </div>
                            <button class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-gray-200 rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="translate-x-0 inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                            </button>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-900">SMS Notifications</h4>
                                <p class="text-sm text-gray-500">Receive SMS updates for important account changes</p>
                            </div>
                            <button class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-gray-200 rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="translate-x-0 inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
