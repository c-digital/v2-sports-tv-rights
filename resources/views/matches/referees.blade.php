<x-template-dashboard active="bolivia.{{ get('competition') == '592' ? 'liga' : 'copa' }}">
    <div class="w-full p-7">
        <h1 class="text-3xl mb-4 soulcraftg {{ get('competition') == '592' ? 'text-[#ffc400]' : 'text-[#ffbe00]' }}">
            {{ get('competition') == '592' ? 'Liga Tigo FBF' : 'Copa Tigo FBF' }}
        </h1>

        <x-alert></x-alert>

        <x-match-nav></x-match-nav>

        <div class="bg-white border rounded shadow p-5 mt-5 text-lg">
            <opta-widget
            	widget="referees"
            	competition="{{ get('competition') }}"
            	season="{{ get('season') }}"
            	template="normal"
            	show_fouls="true"
            	show_penalties="true"
            	show_cards_yellow="true"
            	show_cards_red="true"
            	show_offsides="true"
            	show_cards_per_game="true"
            	show_fouls_per_card="true"
            	show_cards_icons="true"
            	sorting="false"
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
