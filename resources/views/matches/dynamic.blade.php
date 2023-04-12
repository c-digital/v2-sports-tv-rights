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

        <a href="{{ '/match/heat-map?' . queryString() }}" class="match-btn text-center items-center mr-1 p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Mapa de calor
        </a>

        <a href="{{ '/match/replay?' . queryString() }}" class="match-btn text-center items-center mr-1 p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Gol replay
        </a>

        <a href="{{ '/match/standings?' . queryString() }}" class="match-btn text-center items-center mr-1 p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Tabla de posiciones
        </a>

        <a href="{{ '/match/dynamic?' . queryString() }}" class="match-btn text-center items-center mr-1 p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Tabla de posiciones dinámica
        </a>

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
            	breakpoints="400, 700" sport="football">
            </opta-widget>
        </div>
    </div>
</x-template-dashboard>
