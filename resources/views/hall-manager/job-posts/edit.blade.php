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

                        @error('hall_id')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

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
                            placeholder="Example: Waiter"
                            required
                        >

                        @error('title')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

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
                            placeholder="Describe the job responsibilities..."
                        >{{ old('description', $jobPost->description) }}</textarea>

                        @error('description')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

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
                            placeholder="Example: Previous experience, good communication skills..."
                        >{{ old('requirements', $jobPost->requirements) }}</textarea>

                        @error('requirements')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- Salary + Employment Type --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        {{-- Salary --}}
                        <div>

                            <label
                                for="salary"
                                class="block font-medium text-gray-700 mb-2"
                            >
                                Salary per Worker (JD)
                            </label>

                            <input
                                id="salary"
                                type="number"
                                name="salary"
                                value="{{ old('salary', $jobPost->salary) }}"
                                min="0"
                                step="0.01"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Example: 50"
                                required
                            >

                            @error('salary')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Employment Type --}}
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

                            @error('employment_type')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                    {{-- Workers Needed + Deadline --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        {{-- Workers Needed --}}
                        <div>

                            <label
                                for="workers_needed"
                                class="block font-medium text-gray-700 mb-2"
                            >
                                Number of Workers Needed
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

                            @error('workers_needed')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Application Deadline --}}
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
                                min="{{ date('Y-m-d') }}"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                            >

                            @error('deadline')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                    {{-- Work Date + Start Time + End Time --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                        {{-- Work Date --}}
                        <div>

                            <label
                                for="job_date"
                                class="block font-medium text-gray-700 mb-2"
                            >
                                Work Date
                            </label>

                            <input
                                id="job_date"
                                type="date"
                                name="job_date"
                                value="{{ old('job_date', $jobPost->job_date?->format('Y-m-d')) }}"
                                min="{{ date('Y-m-d') }}"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                required
                            >

                            @error('job_date')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- Start Time --}}
                        <div>

                            <label
                                for="start_time"
                                class="block font-medium text-gray-700 mb-2"
                            >
                                Start Time
                            </label>

                            <input
                                id="start_time"
                                type="time"
                                name="start_time"
                                value="{{ old('start_time', $jobPost->start_time?->format('H:i')) }}"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                required
                            >

                            @error('start_time')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        {{-- End Time --}}
                        <div>

                            <label
                                for="end_time"
                                class="block font-medium text-gray-700 mb-2"
                            >
                                End Time
                            </label>

                            <input
                                id="end_time"
                                type="time"
                                name="end_time"
                                value="{{ old('end_time', $jobPost->end_time?->format('H:i')) }}"
                                class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                required
                            >

                            @error('end_time')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                    {{-- Payment Summary --}}
                    <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">

                        <h3 class="font-semibold text-gray-800 mb-3">
                            Payment Summary
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                            {{-- Salary --}}
                            <div>

                                <p class="text-sm text-gray-600">
                                    Salary per Worker
                                </p>

                                <p class="text-lg font-semibold">
                                    <span id="salary_preview">0.00</span> JD
                                </p>

                            </div>

                            {{-- Workers --}}
                            <div>

                                <p class="text-sm text-gray-600">
                                    Workers Needed
                                </p>

                                <p class="text-lg font-semibold">
                                    <span id="workers_preview">0</span>
                                </p>

                            </div>

                            {{-- Total --}}
                            <div>

                                <p class="text-sm text-gray-600">
                                    Total Payment
                                </p>

                                <p class="text-lg font-semibold">
                                    <span id="total_preview">0.00</span> JD
                                </p>

                            </div>

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

                        @error('status')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror

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

    {{-- Payment Summary JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const salaryInput = document.getElementById('salary');
            const workersInput = document.getElementById('workers_needed');

            const salaryPreview = document.getElementById('salary_preview');
            const workersPreview = document.getElementById('workers_preview');
            const totalPreview = document.getElementById('total_preview');

            function updatePaymentSummary() {

                const salary = parseFloat(salaryInput.value) || 0;
                const workers = parseInt(workersInput.value) || 0;

                const total = salary * workers;

                salaryPreview.textContent = salary.toFixed(2);
                workersPreview.textContent = workers;
                totalPreview.textContent = total.toFixed(2);
            }

            salaryInput.addEventListener(
                'input',
                updatePaymentSummary
            );

            workersInput.addEventListener(
                'input',
                updatePaymentSummary
            );

            updatePaymentSummary();

        });
    </script>

</x-app-layout>