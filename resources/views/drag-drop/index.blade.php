<x-template-dashboard active="bolivia.{{ get('competition') == '592' ? 'liga' : 'copa' }}">
	<div class="w-full p-7">
        <h1 class="text-3xl mb-4">{{ get('competition') == '592' ? 'Liga Tigo FBF' : 'Copa Tigo FBF' }}</h1>

        <x-alert></x-alert>

        <x-match-nav></x-match-nav>

        <div class="bg-white border rounded shadow p-5 mt-5 text-black">
            <div class="flex">
            	<div class="w-1/5">
	        		Equipo 1
	        	</div>

	            <div class="field w-3/5 h-[30rem]">
	            	<div class="flex">
	            		<div class="w-2/4">
	            			<i class="fa fa-shirt text-3xl"></i>
	            		</div>

	            		<div class="w-2/4"></div>
	            	</div>
	            </div>

	            <div class="w-1/5">
	            	Equipo 2
	            </div>
            </div>
        </div>
    </div>
</x-template-dashboard>
