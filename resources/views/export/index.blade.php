<x-template-dashboard active="json">
	<div class="w-full p-7">
        <h1 class="text-3xl mb-4">{{ 'Exportar datos' }}</h1>

        <x-alert></x-alert>

        <div class="content-center items-center bg-white border rounded shadow p-5 text-lg">

        	<form action="/export" id="export" method="POST">
		        <div class="mt-6">
		        	<label class="inline-block w-32" for="league">Competición</label>
		        	<select @change="reloadWithLeague()" name="league" id="league" required>
	        			<option value=""></option>
	        			<option {{ get('league') == 344 ? 'selected' : '' }} value="344">Liga Bolivia</option>
	        			<option {{ get('league') == 964 ? 'selected' : '' }} value="964">Copa Bolivia</option>
	        			<option {{ get('league') == 140 ? 'selected' : '' }} value="140">Liga España</option>
	        			<option {{ get('league') == 143 ? 'selected' : '' }} value="143">Copa del Rey</option>
	        			<option {{ get('league') == 39 ? 'selected' : '' }} value="39">Liga Inglaterra</option>
	        			<option {{ get('league') == 2 ? 'selected' : '' }} value="2">Champions League</option>
	        			<option {{ get('league') == 3 ? 'selected' : '' }} value="3">Europa League</option>
	        		</select>
		        </div>

		        @if(! empty($rounds))
		        	<div class="mt-6">
			        	<label class="inline-block w-32" for="round">Fecha</label>
			        	<select @change="reloadWithRound()" name="round" id="round" required>
		        			<option value=""></option>
		        			@foreach($rounds as $round)
		        				<option {{ get('round') == $round ? 'selected' : '' }} value="{{ $round }}">{{ $round }}</option>
		        			@endforeach
		        		</select>
			        </div>
		        @endif

		        @if(! empty($matches))
		        	<div class="mt-6">
			        	<label class="inline-block w-32" for="match">Partido</label>
			        	<select name="fixture" required>
		        			<option value=""></option>
		        			@foreach($matches as $match)
		        				<option {{ get('fixture') == $match->fixture->id ? 'selected' : '' }} value="{{ $match->fixture->id }}">{{ $match->teams->home->name . ' vs ' . $match->teams->away->name }}</option>
		        			@endforeach
		        		</select>
			        </div>
		        @endif

		        <div class="mt-4">
		        	<label class="inline-block w-32" for="type">Tipo</label>
		        	<select name="type" required>
		        		<option value="standings">Tabla de posiciones</option>
		        		<option value="fixture">Fixture</option>
		        		<option value="lineups">Alineaciones</option>
		        		<option value="referees">Árbitros</option>
		        		<option value="stats">Estadísticas</option>
		        		<option value="heatMap">Mapa de calor</option>
		        		<option value="score">Score</option>
		        	</select>
		        </div>

		        <div class="mt-4 mb-6">
		        	<button type="submit" class="text-center items-center p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
		            	<i class="fa fa-spinner mr-2"></i>
	                    Generar
		            </button>

		            @if(get('copy'))
		            	<input type="hidden" id="link" value="{{ linkToCopy() }}">

			            <button type="button" @click="copyToClipboard()" class="text-center items-center p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
			            	<i class="fa fa-copy mr-2"></i>
		                    Copiar enlace
			            </button>
			        @endif
		        </div>
	        </form>
		</div>
    </div>
</x-template-dashboard>