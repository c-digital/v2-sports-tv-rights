<x-template-dashboard active="bolivia.{{ get('competition') == '592' ? 'liga' : 'copa' }}">
    <div class="w-full p-7">
        <h1 class="text-3xl mb-4 soulcraftg {{ get('competition') == '592' ? 'text-[#ffc400]' : 'text-[#ffbe00]' }}">
            {{ get('competition') == '592' ? 'Liga Tigo FBF' : 'Copa Tigo FBF' }}
        </h1>

        <x-alert></x-alert>

        <x-match-nav></x-match-nav>

        <div class="bg-white border rounded shadow p-5 mt-5 text-lg">
            <opta-widget
            	widget="season_standings"
            	competition="{{ get('competition') }}"
            	season="{{ get('season') }}"
            	template="normal"
            	show_competition_name="true"
            	show_team_list="true"
            	preselected_only="false"
            	show_match_header="true"
            	show_date="true"
            	show_match_details="true"
            	show_crests="true"
            	show_axis_labels="true"
            	show_plot_points="true"
            	plot_curves="false"
            	date_format="dddd D MMMM YYYY"
            	competition_naming="full"
            	team_naming="full"
            	show_logo="false"
            	show_title="true"
            	breakpoints="400, 700"
                sport="football"
                team_link="/match/season-teams-stats?">
            </opta-widget>
        </div>
    </div>
</x-template-dashboard>
