<x-template-dashboard active="bolivia.{{ get('competition') == '592' ? 'liga' : 'copa' }}">
    <div class="w-full p-7">
        <h1 class="text-3xl mb-4 soulcraftg {{ get('competition') == '592' ? 'text-[#ffc400]' : 'text-[#ffbe00]' }}">
            {{ get('competition') == '592' ? 'Liga Tigo FBF' : 'Copa Tigo FBF' }}
        </h1>

        <x-alert></x-alert>

        <x-match-nav></x-match-nav>

        <div class="bg-white border rounded shadow p-5 mt-5 text-lg">
            <opta-widget
            	widget="matchstats_pro"
            	competition="{{ get('competition') }}"
            	season="{{ get('season') }}"
            	match="{{ get('match') }}"
            	template="team_graphs"
            	live="true"
            	navigation="tabs_more"
            	default_nav="1"
            	show_match_header="true"
            	show_score="true"
            	show_halftime_score="false"
            	show_crests="true"
            	show_competition_name="true"
            	graph_style="full"
            	show_date="false"
            	date_format="dddd D MMMM YYYY"
            	show_timecontrols="true"
            	show_timecontrols_buttons="true"
            	show_timecontrols_bar="true"
            	extended_content="false"
            	rounding="1"
            	competition_naming="full"
            	team_naming="full"
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
