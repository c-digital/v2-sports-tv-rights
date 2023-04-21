<x-template-dashboard active="export">
	<div class="w-full p-7">
        <h1 class="text-3xl mb-4">{{ 'Exportar datos' }}</h1>

        <x-alert></x-alert>

        <div class="content-center items-center bg-white border rounded shadow p-5 text-lg">

        	<form action="/export" id="export" method="POST">
		        <div class="mt-6">
		        	<label class="inline-block w-32 text-black" for="league">Competición</label>
		        	<select class="text-dark" @change="reloadWithLeague()" name="league" id="league" required>
	        			<option value=""></option>
	        			<option {{ get('league') == 'd9kukruep5g7fthaknhbo2k2c' ? 'selected' : '' }} value="d9kukruep5g7fthaknhbo2k2c">Liga Bolivia</option>
	        			<option {{ get('league') == 'acjvtl7xxvcbcz107c8lieqz8' ? 'selected' : '' }} value="acjvtl7xxvcbcz107c8lieqz8">Copa Bolivia</option>
	        		</select>
		        </div>

		        <div class="mt-4">
		        	<label class="inline-block w-32 text-black" for="type">Tipo</label>
		        	<select class="text-dark" @change="reloadWithType()" id="type" name="type" required>
		        		<option {{ get('type') == 'stadings' ? 'selected' : '' }} value="standings">Tabla de posiciones</option>
		        		<option {{ get('type') == 'fixture' ? 'selected' : '' }} value="fixture">Fixture</option>
		        		<option {{ get('type') == 'lineups' ? 'selected' : '' }} value="lineups">Alineaciones</option>
		        		<option {{ get('type') == 'referees' ? 'selected' : '' }} value="referees">Árbitros</option>
		        		<option {{ get('type') == 'stats' ? 'selected' : '' }} value="stats">Estadísticas</option>
		        		<option {{ get('type') == 'playerStats' ? 'selected' : '' }} value="playerStats">Estadísticas por jugador</option>
		        		<option {{ get('type') == 'heatMap' ? 'selected' : '' }} value="heatMap">Mapa de calor</option>
		        		<option {{ get('type') == 'score' ? 'selected' : '' }} value="score">Score</option>
		        	</select>
		        </div>

		        @if(! empty($rounds))
		        	<div class="mt-6" id="round-container">
			        	<label class="inline-block text-black w-32" for="round">Fecha</label>
			        	<select class="text-dark" @change="reloadWithRound()" name="round" id="round" required>
		        			<option value=""></option>
		        			@foreach($rounds as $round)
		        				<option {{ get('round') == $round ? 'selected' : '' }} value="{{ $round }}">{{ $round }}</option>
		        			@endforeach
		        		</select>
			        </div>
		        @endif

		        @if(! empty($matches) && get('type') != 'fixture' && get('type') != 'standings')
		        	<div @change="reloadWithMatch()" class="text-black mt-6" id="match-container">
			        	<label class="inline-block w-32" for="match">Partido</label>
			        	<select class="text-dark" name="fixture" id="match" required>
		        			<option value=""></option>
		        			@foreach($matches as $match)
		        				<option {{ get('fixture') == $match->matchInfo->id ? 'selected' : '' }} value="{{ $match->matchInfo->id }}">{{ $match->matchInfo->contestant[0]->name . ' vs ' . $match->matchInfo->contestant[1]->name }}</option>
		        			@endforeach
		        		</select>
			        </div>
		        @endif

		        @if(get('fixture') && get('type') == 'playerStats')
		        	<div class="mt-6" id="player-container">
			        	<label class="inline-block w-32 text-black" for="player">Jugador</label>
			        	<select class="text-dark" name="player" id="player" required>
		        			<option value=""></option>

		        			@foreach($players as $player)
		        				<option {{ get('player') == $player['id'] ? 'selected' : '' }} value="{{ $player['id'] }}">{{ $player['name'] }}</option>
		        			@endforeach
		        		</select>
			        </div>
		        @endif

		        <div class="mt-4 mb-6">
		        	<button type="submit" class="text-center items-center p-3 appearance-none bg-black btn-blue-tigo border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
		            	<i class="fa fa-spinner mr-2"></i>
	                    Generar
		            </button>

		            @if(get('copy'))
		            	<input type="hidden" id="link" value="{{ linkToCopy() }}">

			            <button type="button" @click="copyToClipboard()" class="btn-blue-tigo text-center items-center p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
			            	<i class="fa fa-copy mr-2"></i>
		                    Copiar enlace
			            </button>
			        @endif
		        </div>
	        </form>
		</div>
    </div>
</x-template-dashboard>