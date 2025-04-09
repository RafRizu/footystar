<x-app-layout>
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white p-6 shadow-md rounded-2xl">
            <h2 class="text-2xl font-bold mb-4">Your Player Info</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <p class="text-gray-500">Nickname</p>
                    <p class="text-lg font-semibold">{{ $player->nickname }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Role</p>
                    <p class="text-lg font-semibold">{{ ucfirst($player->role) }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Rank</p>
                    <p class="text-lg font-semibold">{{ $player->rank }} ({{ $player->stars }}⭐)</p>
                </div>
                <div>
                    <p class="text-gray-500">Money</p>
                    <p class="text-lg font-semibold">💰 {{ number_format($player->money) }}</p>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <form method="POST" action="{{ route('player.ranked') }}">
                    @csrf
                    <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg">
                        Play Match
                    </button>
                </form>
                {{-- Future: Training system --}}
                <a href="#"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg">Train Player</a>
            </div>
        </div>

        <div class="bg-white p-6 shadow-md rounded-2xl">
            <h2 class="text-2xl font-bold mb-4">Recent Matches</h2>
            <table class="min-w-full text-center">
                <thead>
                    <tr>
                        <th class="py-2">Result</th>
                        <th class="py-2">Stars Change</th>
                        <th class="py-2">Stars After</th>
                        <th class="py-2">Rank After</th>
                        <th class="py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentMatches as $match)
                        <tr class="border-t">
                            <td class="py-2 {{ $match->result === 'win' ? 'text-green-600' : 'text-red-600' }}">
                                {{ ucfirst($match->result) }}</td>
                            <td class="py-2">{{ $match->stars_change > 0 ? '+' : '' }}{{ $match->stars_change }}</td>
                            <td class="py-2">{{ $match->stars_after_match }}</td>
                            <td class="py-2">{{ $match->rank_after_match }}</td>
                            <td class="py-2">{{ $match->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
