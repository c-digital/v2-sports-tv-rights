<x-template-dashboard active="bolivia.{{ get('competition') == '592' ? 'liga' : 'copa' }}">
	<div class="w-full p-7">
        <h1 class="text-3xl mb-4 soulcraftg {{ get('competition') == '592' ? 'text-[#ffc400]' : 'text-[#ffbe00]' }}">
            {{ get('competition') == '592' ? 'Liga Tigo FBF' : 'Copa Tigo FBF' }}
        </h1>

        <x-alert></x-alert>

        <x-match-nav></x-match-nav>

        <div class="bg-white border rounded shadow p-5 mt-5 text-lg">
            <opta-widget
                sport="football"
                widget="match_summary"
                template="normal"
                live="true"
                competition="{{ get('competition') }}"
                season="{{ get('season') }}"
                match="{{ get('match') }}"
                show_match_header="true"
                show_attendance="true"
                show_cards="true"
                show_crests="true"
                show_goals="true"
                show_goals_combined="false"
                show_penalties_missed="false"
                show_referee="true"
                show_subs="true"
                show_venue="true"
                show_shootouts="false"
                player_naming="last_name"
                player_link=""
                show_logo="false"
                breakpoints="400"
                team_link="/match/season-teams-stats?">
            </opta-widget>
        </div>
    </div>
</x-template-dashboard>
