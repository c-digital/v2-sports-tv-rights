<x-template-dashboard active="bolivia.liga">
	<div class="w-full p-7">
        <h1 class="text-3xl mb-4">{{ 'Liga Bolivia' }}</h1>

        <x-alert></x-alert>

        <div class="bg-white border rounded shadow p-5 text-lg">
            <opta-widget
            	widget="fixtures"
            	competition="592"
            	season="2023"
            	template="normal"
            	live="true"
            	date_from="2023-04-06"
            	date_to="2023-04-06"
            	show_venue="false"
            	match_status="all"
            	grouping="date"
            	show_grouping="true"
            	navigation="none"
            	default_nav="1"
            	start_on_current="true"
            	sub_grouping="date"
            	show_subgrouping="false"
            	order_by="date_ascending"
            	show_crests="false"
            	date_format="dddd D MMMM YYYY"
            	time_format="HH:mm"
            	month_date_format="MMMM"
            	competition_naming="full"
            	team_naming="full"
            	pre_match="false"
            	show_live="false"
            	show_logo="true"
            	show_title="true"
            	breakpoints="400"
            	sport="football">
            </opta-widget>
        </div>
    </div>
</x-template-dashboard>
