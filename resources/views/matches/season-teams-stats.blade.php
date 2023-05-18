<x-template-dashboard active="bolivia.{{ get('competition') == '592' ? 'liga' : 'copa' }}">
    <div class="w-full p-7">
        <h1 class="text-3xl mb-4 soulcraftg {{ get('competition') == '592' ? 'text-[#ffc400]' : 'text-[#ffbe00]' }}">
            {{ get('competition') == '592' ? 'Liga Tigo FBF' : 'Copa Tigo FBF' }}
        </h1>

        <x-alert></x-alert>

        <x-match-nav></x-match-nav>

        <div class="bg-white border rounded shadow p-5 mt-5 text-lg">
            <opta-widget widget="season_team_stats"
                competition="{{ get('competition') }}"
                season="{{ get('season') }}"
                team="{{ get('team') }}"
                template="normal"
                navigation="tabs_more"
                default_nav="1"
                show_general="true"
                show_distribution="true"
                show_attack="true"
                show_defence="true"
                show_discipline="true"
                team_naming="full"
                show_logo="false"
                show_title="true"
                breakpoints="400"
                sport="football">        
            </opta-widget>
        </div>
    </div>
</x-template-dashboard>
