<x-template-dashboard active="bolivia.{{ get('competition') == '592' ? 'liga' : 'copa' }}">
    <div class="w-full p-7">
        <h1 class="text-3xl mb-4 soulcraftg {{ get('competition') == '592' ? 'text-[#ffc400]' : 'text-[#ffbe00]' }}">
            {{ get('competition') == '592' ? 'Liga Tigo FBF' : 'Copa Tigo FBF' }}
        </h1>

        <x-alert></x-alert>

        <x-match-nav></x-match-nav>

        <div class="bg-white border rounded shadow p-5 mt-5 text-lg">
            <opta-widget
                widget="penalty_history"
                competition="{{ get('competition') }}"
                season="{{ get('season') }}"
                match="{{ get('match') }}"
                preselected_player="all"
                template="normal"
                show_selects="true"
                show_tooltips="false"
                show_goals="true"
                show_penalties_missed="true"
                show_grid="true"
                show_subs="true"
                show_match_header="true"
                show_score="true"
                show_crests="true"
                show_attendance="true"
                show_date="true"
                date_format="dddd D MMMM YYYY HH:mm"
                show_team_formation="true"
                show_halftime_score="false"
                show_referee="true"
                show_venue="true"
                show_images="false"
                show_competition_name="true"
                competition_naming="full"
                team_naming="full"
                player_naming="full"
                show_logo="false"
                show_title="true"
                breakpoints="400"
                sport="football"
                team_link="/match/season-teams-stats?">                
            </opta-widget>
        </div>
    </div>
</x-template-dashboard>
