<x-template-dashboard active="json">
	<div class="w-full p-7">
        <h1 class="text-3xl mb-4">{{ 'Descargar JSON' }}</h1>

        <x-alert></x-alert>

        <div class="content-center items-center bg-white border rounded shadow p-5 text-lg">

        	<form action="/json" method="POST">
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
		        	<label for="date">Fecha</label>
		        	<input type="date" name="date" required value="{{ now('Y-m-d') }}">
		        </div>

		        <div class="mt-4 mb-6">
		        	<x-button color="black">
	                    <i class="fa fa-download mr-2"></i>
	                    Descargar JSON
	                </x-button>
		        </div>
	        </form>
		</div>
    </div>
</x-template-dashboard>