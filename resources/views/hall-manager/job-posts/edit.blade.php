<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Job Advertisement
            </h2>

            <a
                href="{{ route('hall-manager.job-posts.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg"
            >
                Back to Job Advertisements
            </a>

        </div>

    </x-slot>


    <div class="py-8">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">


                {{-- Validation Errors --}}

                @if ($errors->any())

                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-4 rounded-lg">

                        <ul class="list-disc list-inside">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('hall-manager.job-posts.update', $jobPost) }}"
                >

                    @csrf

                    @method('PUT')


                    {{-- Hall --}}

                    <div class="mb-6">

                        <label
                            for="hall_id"
                            class="block font-medium text-gray-700 mb-2"
                        >
                            Hall
                        </label>

                        <select
                            id="hall_id"
                            name="hall_id"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required
                        >

                            @foreach ($halls as $hall)

                                <option
                                    value="{{ $hall->id }}"
                                    {{ old('hall_id', $jobPost->hall_id) == $hall->id ? 'selected' : '' }}
                                >
                                    {{ $hall->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- Job Title --}}

                    <div class="mb-6">

                        <label
                            for="title"
                            class="block font-medium text-gray-700 mb-2"
                        >
                            Job Title
                        </label>

                        <input
                            id="title"
                            type="text"
                            name="title"
                            value="{{ old('title', $jobPost->title) }}"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required
                        >

                    </div>


                    {{-- Description --}}

                    <div class="mb-6">

                        <label
                            for="description"
                            class="block font-medium text-gray-700 mb-2"
                        >
                            Job Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        >{{ old('description', $jobPost->description) }}</textarea>

                    </div>


                    {{-- Requirements --}}

                    <div class="mb-6">

                        <label
                            for="requirements"
                            class="block font-medium text-gray-700 mb-2"
                        >
                            Requirements
                        </label>

                        <textarea
                            id="requirements"
                            name="requirements"
                            rows="5"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        >{{ old('requirements', $jobPost->requirements) }}</textarea>

                    </div>


                    {{-- Salary + Employment Type --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">


                        <div>

                            <label
                                for="salary"
                                class="block font-medium text-gray-700 mb-2"
                            >
                                Salary
                            </label>

                            <input
                                id="salary"
                                type="number"
                                name="salary"
                                value="{{ old('salary', $jobPost->salary) }}"
                                min="0"
                                step="0.01"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            >

                        </div>


                        <div>

                            <label
                                for="employment_type"
                                class="block font-medium text-gray-700 mb-2"
                            >
                                Employment Type
                            </label>

                            <select
                                id="employment_type"
                                name="employment_type"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            >

                                <option value="">
                                    Select Employment Type
                                </option>

                                <option
                                    value="Full Time"
                                    {{ old('employment_type', $jobPost->employment_type) === 'Full Time' ? 'selected' : '' }}
                                >
                                    Full Time
                                </option>

                                <option
                                    value="Part Time"
                                    {{ old('employment_type', $jobPost->employment_type) === 'Part Time' ? 'selected' : '' }}
                                >
                                    Part Time
                                </option>

                                <option
                                    value="Temporary"
                                    {{ old('employment_type', $jobPost->employment_type) === 'Temporary' ? 'selected' : '' }}
                                >
                                    Temporary
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- Workers Needed + Deadline --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">


                        <div>

                            <label
                                for="workers_needed"
                                class="block font-medium text-gray-700 mb-2"
                            >
                                Workers Needed
                            </label>

                            <input
                                id="workers_needed"
                                type="number"
                                name="workers_needed"
                                value="{{ old('workers_needed', $jobPost->workers_needed) }}"
                                min="1"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                required
                            >

                        </div>


                        <div>

                            <label
                                for="deadline"
                                class="block font-medium text-gray-700 mb-2"
                            >
                                Application Deadline
                            </label>

                            <input
                                id="deadline"
                                type="date"
                                name="deadline"
                                value="{{ old('deadline', $jobPost->deadline?->format('Y-m-d')) }}"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            >

                        </div>

                    </div>


                    {{-- Status --}}

                    <div class="mb-8">

                        <label
                            for="status"
                            class="block font-medium text-gray-700 mb-2"
                        >
                            Status
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            required
                        >

                            <option
                                value="open"
                                {{ old('status', $jobPost->status) === 'open' ? 'selected' : '' }}
                            >
                                Open
                            </option>

                            <option
                                value="closed"
                                {{ old('status', $jobPost->status) === 'closed' ? 'selected' : '' }}
                            >
                                Closed
                            </option>

                        </select>

                    </div>


                    {{-- Buttons --}}

                    <div class="flex items-center gap-3">

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium"
                        >
                            Update Job Advertisement
                        </button>

                        <a
                            href="{{ route('hall-manager.job-posts.show', $jobPost) }}"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium"
                        >
                            Cancel
                        </a>

                    </div>


                </form>

            </div>

        </div>

    </div>

</x-app-layout>