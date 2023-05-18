<x-template-dashboard active="bolivia.{{ get('competition') == '592' ? 'liga' : 'copa' }}">
    <div class="w-full p-7">
        <h1 class="text-3xl mb-4 soulcraftg {{ get('competition') == '592' ? 'text-[#ffc400]' : 'text-[#ffbe00]' }}">
            {{ get('competition') == '592' ? 'Liga Tigo FBF' : 'Copa Tigo FBF' }}
        </h1>

        <x-alert></x-alert>

        <x-match-nav></x-match-nav>

        <div class="bg-white border rounded shadow p-5 mt-5 text-lg">
            <opta-widget
                widget="competition_stats"
                competition="{{ get('competition') }}"
                season="{{ get('season') }}"
                template="normal"
                show_crests="true"
                show_images="true"
                show_ranks="true"
                show_player_rankings="true"
                show_team_rankings="true"
                visible_stats="goals,shots,shots_on_target,passes,cards_yellow,cards_red,goals_per_game,corners,penalties,fouls,clean_sheets,goals_conceded,clearances,games_played"
                limit="100"
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
