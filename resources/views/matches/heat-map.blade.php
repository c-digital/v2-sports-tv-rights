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

        <br><br>

        <a href="{{ '/match/compare?' . queryString() }}" class="match-btn text-center items-center mr-1 p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Comparación de jugadores
        </a>

        <a href="{{ '/match/referees?' . queryString() }}" class="match-btn text-center items-center mr-1 p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Árbitros
        </a>

        <a href="{{ '/match/competition-stats?' . queryString() }}" class="match-btn text-center items-center mr-1 p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Estadísticas de competición
        </a>

        <a href="{{ '/match/penalty-history?' . queryString() }}" class="match-btn text-center items-center mr-1 p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
            Historial de penaltis
        </a>

        <div class="bg-white border rounded shadow p-5 mt-5 text-lg">
            <opta-widget widget="heatmap"
            	competition="{{ get('competition') }}"
            	season="{{ get('season') }}"
            	match="{{ get('match') }}"
            	preselected_player="all"
            	template="normal"
            	live="true"
            	show_maps="all"
            	orientation="horizontal"
            	side="both"
            	dimension="2D"
            	one_direction="false"
            	show_match_header="true"
            	show_score="true"
            	show_halftime_score="false"
            	show_crests="true"
            	show_team_formation="true"
            	show_competition_name="true"
            	show_date="true"
            	date_format="dddd D MMMM YYYY"
            	show_team_sheets="true"
            	show_subs="true"
            	show_position="true"
            	show_timecontrols="true"
            	show_timecontrols_buttons="true"
            	show_timecontrols_bar="true"
            	show_tooltips="false"
            	competition_naming="full"
            	team_naming="full"
            	player_naming="full"
            	show_logo="false"
            	show_title="true"
            	breakpoints="400, 700"
            	sport="football"
                team_link="/match/season-teams-stats?">
            </opta-widget>
        </div>
    </div>
</x-template-dashboard>
