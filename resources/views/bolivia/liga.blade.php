<x-template-dashboard active="bolivia.liga">
	<div class="w-full p-7">
        <div class="flex justify-between">
            <div>
                <h1 class="text-3xl mb-4">{{ 'Liga Tigo FBF' }}</h1>
            </div>

            <div>
                <input class="text-black" @change="refreshPage()" id="date" type="date" name="date" value="{{ get('date') ?? now('Y-m-d') }}">
            </div>
        </div>

        <x-alert></x-alert>

        <div class="bg-white rounded shadow p-5 text-lg">
            <opta-widget
                widget="fixtures"
                competition="592"
                season="2023"
                template="normal"
                live="true"
                date_from="{{ get('date') ?? now('Y-m-d') }}"
                date_to="{{ get('date') ?? now('Y-m-d') }}"
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
                show_crests="true"
                date_format="dddd D MMMM YYYY"
                time_format="HH:mm"
                month_date_format="MMMM"
                competition_naming="full"
                team_naming="full"
                pre_match="true"
                show_live="true"
                match_link="/match/summary?"
                show_logo="false"
                show_title="true"
                breakpoints="400"
                sport="football"
                team_link="/match/season-teams-stats?">
            </opta-widget>
        </div>
    </div>
</x-template-dashboard>
