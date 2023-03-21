<x-template-dashboard active="json">
	<div class="w-full p-7">
        <h1 class="text-3xl mb-4">{{ 'Exportar datos' }}</h1>

        <x-alert></x-alert>

        <div class="content-center items-center bg-white border rounded shadow p-5 text-lg">

        	<form action="/export" id="export" method="POST">
		        <div class="mt-6">
		        	<label for="league">Competición</label>
		        	<select name="league" required>
	        			<option value="344">Liga Bolivia</option>
	        			<option value="964">Copa Bolivia</option>
	        			<option value="140">Liga España</option>
	        			<option value="143">Copa del Rey</option>
	        			<option value="39">Liga Inglaterra</option>
	        			<option value="2">Champions League</option>
	        			<option value="3">Europa League</option>
	        		</select>
		        </div>

		        <div class="mt-4">
		        	<label for="type">Tipo</label>
		        	<select x-model="type" @change="showFields()" name="type" required>
		        		<option value="standings">Tabla de posiciones</option>
		        		<option value="fixture">Fixture</option>
		        		<option value="lineups">Alineaciones</option>
		        		<option value="referees">Árbitros</option>
		        		<option value="stats">Estadísticas</option>
		        		<option value="heatMap">Mapa de calor</option>
		        		<option value="score">Score</option>
		        	</select>
		        </div>

		        <div x-html="moreFields"></div>

		        <div class="mt-4 mb-6">
		        	<button type="submit" class="text-center items-center p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
		            	<i class="fa fa-spinner mr-2"></i>
	                    Generar
		            </button>

		            @if(request('filename'))
			            <a href="{{ request('filename') }}" class="text-center items-center p-3 appearance-none bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-black active:bg-black focus:outline-none focus:border-black focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
			            	<i class="fa fa-download mr-2"></i>
		                    Descargar
			            </a>
		            @endif
		        </div>
	        </form>
		</div>
    </div>
</x-template-dashboard>