<x-template-dashboard active="bolivia.{{ get('competition') == '592' ? 'liga' : 'copa' }}">
    <div class="w-full p-7">
        <h1 class="text-3xl mb-4 soulcraftg {{ get('competition') == '592' ? 'text-[#ffc400]' : 'text-[#ffbe00]' }}">
            {{ get('competition') == '592' ? 'Liga Tigo FBF' : 'Copa Tigo FBF' }}
        </h1>

        <x-alert></x-alert>

        <x-match-nav></x-match-nav>

        <div class="bg-white border rounded shadow p-5 mt-5 text-lg">
            <opta-widget widget="matchday_live"
                competition="{{ get('competition') }}"
                season="{{ get('season') }}"
                match="{{ get('match') }}"
                template="normal"
                live="true"
                orientation="horizontal"
                side="both"
                show_match_header="true"
                show_crests="true"
                show_pitch_crests="false"
                show_team_formation="true"
                show_score="true"
                show_halftime_score="false"
                show_competition_name="true"
                show_date="true"
                date_format="dddd D MMMM YYYY"
                show_referee="true"
                show_venue="true"
                show_attendance="true"
                show_images="false"
                show_pitch_images="false"
                show_team_sheets="true"
                show_event_icons="true"
                show_player_names="true"
                show_player_stats="true"
                show_subs="all"
                competition_naming="full"
                team_naming="full"
                player_naming="full"
                show_live="true"
                show_logo="false"
                show_title="true"
                breakpoints="400, 700"
                sport="football"
                team_link="/match/season-teams-stats?">
            </opta-widget>
        </div>
    </div>
</x-template-dashboard>
