<x-template-dashboard active="bolivia.{{ get('competition') == '592' ? 'liga' : 'copa' }}">
    <div class="w-full p-7">
        <h1 class="text-3xl mb-4 soulcraftg {{ get('competition') == '592' ? 'text-[#ffc400]' : 'text-[#ffbe00]' }}">
            {{ get('competition') == '592' ? 'Liga Tigo FBF' : 'Copa Tigo FBF' }}
        </h1>

        <x-alert></x-alert>

        <x-match-nav></x-match-nav>

        <div class="bg-white border rounded shadow p-5 mt-5 text-lg">
            <opta-widget
                widget="standings"
                competition="{{ get('competition') }}"
                season="{{ get('season') }}"
                template="normal"
                live="true"
                default_nav="1"
                side="combined"
                data_detail="default"
                show_key="false"
                show_crests="true"
                points_in_first_column="false"
                lose_before_draw="false"
                show_form="6"
                competition_naming="full"
                team_naming="full"
                date_format="dddd D MMMM YYYY"
                sorting="false"
                show_live="true"
                show_relegation_average="false"
                show_logo="false"
                show_title="true"
                breakpoints="400"
                sport="football"
                team_link="/match/season-teams-stats?">
            </opta-widget>
        </div>
    </div>
</x-template-dashboard>
