<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Job Advertisements
            </h2>

            <a
                href="{{ route('hall-manager.job-posts.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg"
            >
                + Add Job Advertisement
            </a>

        </div>

    </x-slot>

    <div class="py-8">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))

                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">

                    {{ session('success') }}

                </div>

            @endif

            {{-- Error Messages --}}
            @if ($errors->any())

                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

                    <ul class="list-disc list-inside">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif

            @if ($jobPosts->count() > 0)

                <div class="bg-white shadow-sm rounded-lg overflow-hidden">

                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead class="bg-gray-100">

                                <tr>

                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                        Job Title
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                        Hall
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                        Employment Type
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                        Salary
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                        Workers
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                        Work Date
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                        Time
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                        Deadline
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                                        Actions
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @foreach ($jobPosts as $jobPost)

                                    <tr class="hover:bg-gray-50">

                                        {{-- Job Title --}}
                                        <td class="px-6 py-4">

                                            <div class="font-semibold text-gray-900">
                                                {{ $jobPost->title }}
                                            </div>

                                            @if ($jobPost->description)

                                                <div class="text-sm text-gray-500 mt-1 max-w-xs truncate">
                                                    {{ $jobPost->description }}
                                                </div>

                                            @endif

                                        </td>

                                        {{-- Hall --}}
                                        <td class="px-6 py-4 text-gray-700">

                                            {{ $jobPost->hall?->name ?? '-' }}

                                        </td>

                                        {{-- Employment Type --}}
                                        <td class="px-6 py-4 text-gray-700">

                                            {{ $jobPost->employment_type ?? '-' }}

                                        </td>

                                        {{-- Salary --}}
                                        <td class="px-6 py-4 text-gray-700">

                                            @if ($jobPost->salary !== null)

                                                {{ number_format((float) $jobPost->salary, 2) }} JD

                                            @else

                                                -

                                            @endif

                                        </td>

                                        {{-- Workers Needed --}}
                                        <td class="px-6 py-4 text-gray-700">

                                            {{ $jobPost->workers_needed }}

                                        </td>

                                        {{-- Work Date --}}
                                        <td class="px-6 py-4 text-gray-700 whitespace-nowrap">

                                            @if ($jobPost->job_date)

                                                {{ $jobPost->job_date->format('Y-m-d') }}

                                            @else

                                                -

                                            @endif

                                        </td>

                                        {{-- Work Time --}}
                                        <td class="px-6 py-4 text-gray-700 whitespace-nowrap">

                                            @if ($jobPost->start_time && $jobPost->end_time)

                                                {{ $jobPost->start_time->format('H:i') }}
                                                -
                                                {{ $jobPost->end_time->format('H:i') }}

                                            @else

                                                -

                                            @endif

                                        </td>

                                        {{-- Deadline --}}
                                        <td class="px-6 py-4 text-gray-700 whitespace-nowrap">

                                            @if ($jobPost->deadline)

                                                {{ $jobPost->deadline->format('Y-m-d') }}

                                            @else

                                                -

                                            @endif

                                        </td>

                                        {{-- Status --}}
                                        <td class="px-6 py-4">

                                            @if ($jobPost->status === 'open')

                                                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-green-100 text-green-700">
                                                    Open
                                                </span>

                                            @else

                                                <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-700">
                                                    Closed
                                                </span>

                                            @endif

                                        </td>

                                        {{-- Actions --}}
                                        <td class="px-6 py-4">

                                            <div class="flex items-center gap-3">

                                                {{-- View --}}
                                                <a
                                                    href="{{ route('hall-manager.job-posts.show', $jobPost) }}"
                                                    class="text-blue-600 hover:text-blue-800 font-medium"
                                                >
                                                    View
                                                </a>

                                                {{-- Edit --}}
                                                <a
                                                    href="{{ route('hall-manager.job-posts.edit', $jobPost) }}"
                                                    class="text-yellow-600 hover:text-yellow-800 font-medium"
                                                >
                                                    Edit
                                                </a>

                                                {{-- Delete --}}
                                                <form
                                                    method="POST"
                                                    action="{{ route('hall-manager.job-posts.destroy', $jobPost) }}"
                                                    onsubmit="return confirm('Are you sure you want to delete this job advertisement?');"
                                                >

                                                    @csrf

                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="text-red-600 hover:text-red-800 font-medium"
                                                    >
                                                        Delete
                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            @else

                {{-- No Job Advertisements --}}

                <div class="bg-white shadow-sm rounded-lg p-10 text-center">

                    <h3 class="text-xl font-semibold text-gray-800 mb-3">
                        No Job Advertisements
                    </h3>

                    <p class="text-gray-600 mb-6">
                        You have not created any job advertisements yet.
                    </p>

                    <a
                        href="{{ route('hall-manager.job-posts.create') }}"
                        class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg"
                    >
                        Create Your First Job Advertisement
                    </a>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>