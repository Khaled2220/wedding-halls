<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Job Advertisement Details
            </h2>

            <div class="flex gap-3">

                <a
                    href="{{ route('hall-manager.job-posts.edit', $jobPost) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg"
                >
                    Edit
                </a>

                <a
                    href="{{ route('hall-manager.job-posts.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg"
                >
                    Back
                </a>

            </div>

        </div>

    </x-slot>

    <div class="py-8">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))

                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                    {{ session('success') }}

                </div>

            @endif

            <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                {{-- Header --}}
                <div class="p-6 border-b">

                    <div class="flex justify-between items-start gap-4">

                        <div>

                            <h1 class="text-2xl font-bold text-gray-900">
                                {{ $jobPost->title }}
                            </h1>

                            <p class="text-gray-600 mt-2">
                                {{ $jobPost->hall?->name ?? '-' }}
                            </p>

                        </div>

                        {{-- Status --}}
                        @if ($jobPost->status === 'open')

                            <span class="inline-flex px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-700">
                                Open
                            </span>

                        @else

                            <span class="inline-flex px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700">
                                Closed
                            </span>

                        @endif

                    </div>

                </div>

                {{-- Job Information --}}
                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                        {{-- Hall --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Hall
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">
                                {{ $jobPost->hall?->name ?? '-' }}
                            </p>

                        </div>

                        {{-- Employment Type --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Employment Type
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">
                                {{ $jobPost->employment_type ?? '-' }}
                            </p>

                        </div>

                        {{-- Salary --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Salary per Worker
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">

                                @if ($jobPost->salary !== null)

                                    {{ number_format((float) $jobPost->salary, 2) }} JD

                                @else

                                    -

                                @endif

                            </p>

                        </div>

                        {{-- Workers Needed --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Workers Needed
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">
                                {{ $jobPost->workers_needed }}
                            </p>

                        </div>

                        {{-- Work Date --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Work Date
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">

                                @if ($jobPost->job_date)

                                    {{ $jobPost->job_date->format('Y-m-d') }}

                                @else

                                    -

                                @endif

                            </p>

                        </div>

                        {{-- Work Time --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Work Time
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">

                                @if ($jobPost->start_time && $jobPost->end_time)

                                    {{ $jobPost->start_time->format('H:i') }}
                                    -
                                    {{ $jobPost->end_time->format('H:i') }}

                                @else

                                    -

                                @endif

                            </p>

                        </div>

                        {{-- Deadline --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Application Deadline
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">

                                @if ($jobPost->deadline)

                                    {{ $jobPost->deadline->format('Y-m-d') }}

                                @else

                                    No Deadline

                                @endif

                            </p>

                        </div>

                        {{-- Created At --}}
                        <div>

                            <p class="text-sm text-gray-500">
                                Created At
                            </p>

                            <p class="font-semibold text-gray-900 mt-1">

                                {{ $jobPost->created_at->format('Y-m-d H:i') }}

                            </p>

                        </div>

                    </div>

                    {{-- Payment Summary --}}
                    <div class="mb-8 bg-blue-50 border border-blue-200 rounded-lg p-5">

                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Payment Summary
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            {{-- Salary --}}
                            <div>

                                <p class="text-sm text-gray-600">
                                    Salary per Worker
                                </p>

                                <p class="text-xl font-bold text-gray-900 mt-1">

                                    @if ($jobPost->salary !== null)

                                        {{ number_format((float) $jobPost->salary, 2) }} JD

                                    @else

                                        0.00 JD

                                    @endif

                                </p>

                            </div>

                            {{-- Workers --}}
                            <div>

                                <p class="text-sm text-gray-600">
                                    Workers Needed
                                </p>

                                <p class="text-xl font-bold text-gray-900 mt-1">
                                    {{ $jobPost->workers_needed }}
                                </p>

                            </div>

                            {{-- Total --}}
                            <div>

                                <p class="text-sm text-gray-600">
                                    Total Payment
                                </p>

                                <p class="text-xl font-bold text-blue-700 mt-1">

                                    {{
                                        number_format(
                                            (float) $jobPost->salary * $jobPost->workers_needed,
                                            2
                                        )
                                    }}

                                    JD

                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Description --}}
                    <div class="mb-8">

                        <h3 class="text-lg font-semibold text-gray-900 mb-3">
                            Job Description
                        </h3>

                        <div class="bg-gray-50 rounded-lg p-5 text-gray-700 whitespace-pre-line">

                            {{ $jobPost->description ?: 'No description provided.' }}

                        </div>

                    </div>

                    {{-- Requirements --}}
                    <div class="mb-8">

                        <h3 class="text-lg font-semibold text-gray-900 mb-3">
                            Requirements
                        </h3>

                        <div class="bg-gray-50 rounded-lg p-5 text-gray-700 whitespace-pre-line">

                            {{ $jobPost->requirements ?: 'No requirements provided.' }}

                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center justify-between border-t pt-6">

                        <a
                            href="{{ route('hall-manager.job-posts.index') }}"
                            class="text-gray-600 hover:text-gray-900 font-medium"
                        >
                            ← Back to Job Advertisements
                        </a>

                        <div class="flex gap-3">

                            <a
                                href="{{ route('hall-manager.job-posts.edit', $jobPost) }}"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg"
                            >
                                Edit
                            </a>

                            <form
                                method="POST"
                                action="{{ route('hall-manager.job-posts.destroy', $jobPost) }}"
                                onsubmit="return confirm('Are you sure you want to delete this job advertisement?');"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-lg"
                                >
                                    Delete
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>