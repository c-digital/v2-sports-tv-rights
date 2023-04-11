<x-template-dashboard active="bolivia.{{ get('competition') == '592' ? 'liga' : 'copa' }}">
	<div class="w-full p-7">
        <h1 class="text-3xl mb-4">{{ get('competition') == '592' ? 'Liga Tigo FBF' : 'Copa Tigo FBF' }}</h1>

        <x-alert></x-alert>

        <a href="{{ '/match/summary?' . queryString() }}" class="match-btn text-center items-center mr-1 p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Sumario
        </a>

        <a href="{{ '/match/lineups?' . queryString() }}" class="match-btn text-center items-center mr-1 p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Alineaciones
        </a>

        <a href="{{ '/match/stats?' . queryString() }}" class="match-btn text-center items-center mr-1 p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Estadística
        </a>

        <a href="{{ '/match/heat-map?' . queryString() }}" class="match-btn text-center items-center p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Mapa de calor
        </a>

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
                breakpoints="400">
            </opta-widget>
        </div>
    </div>
</x-template-dashboard>
