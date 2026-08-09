<div class="space-y-8">
    <!-- 1. Welcome Banner -->
    <livewire:student.widgets.welcome-banner />

    <!-- 2. Learning Statistics Grid (7 Metric Cards) -->
    <livewire:student.widgets.learning-statistics />

    <!-- Main Grid Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Left Column (8 Cols) -->
        <div class="lg:col-span-8 space-y-8">
            <!-- 3. Continue Learning -->
            <livewire:student.widgets.continue-learning />


            <!-- 4. Upcoming Live Classes -->
            <livewire:student.widgets.upcoming-classes />

            <!-- 5. Recent Certificates -->
            <livewire:student.widgets.recent-certificates />

            <!-- 6. Recommended Courses -->
            <livewire:student.widgets.recommended-courses />
        </div>

        <!-- Right Column (4 Cols) -->
        <div class="lg:col-span-4 space-y-8">
            <!-- 7. Quick Actions Shortcuts -->
            <livewire:student.widgets.quick-actions />

            <!-- 8. AI Insight 

            <!-- 9. Career Placement Progress -->
            <livewire:student.widgets.career-progress />

            <!-- 10. Learning Calendar -->
            <livewire:student.widgets.learning-calendar />

            <!-- 11. Latest Notifications -->
            <livewire:student.widgets.notifications-widget />
        </div>
    </div>

    <!-- Full-Width Bottom Section -->
    <div class="space-y-8">
        <!-- 12. Recommended Jobs -->
        <livewire:student.widgets.recommended-jobs />
    </div>
</div>
