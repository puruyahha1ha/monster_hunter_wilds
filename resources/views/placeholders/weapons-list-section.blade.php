<div>
    <div class="mb-4">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <h2 class="text-2xl font-bold tracking-tight text-white">
                武器一覧
            </h2>
            <div class="flex flex-wrap gap-2">
                <div class="h-9 w-32 bg-gray-700 rounded-md animate-pulse"></div>
                <div class="h-9 w-28 bg-gray-700 rounded-md animate-pulse"></div>
                <div class="h-9 w-24 bg-gray-700 rounded-md animate-pulse"></div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-lg border border-gray-700 bg-gray-900 shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-800">
                    <tr>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            武器名
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            種類
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            レア度
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            攻撃力
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            属性
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            会心率
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">
                            スロット
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700 bg-gray-900">
                    @for ($i = 0; $i < 10; $i++)
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gray-800 rounded-md animate-pulse"></div>
                                    <div class="ml-3">
                                        <div class="h-4 w-32 bg-gray-800 rounded animate-pulse"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="h-4 w-16 bg-gray-800 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex">
                                    @for ($j = 0; $j < 5; $j++)
                                        <div class="h-4 w-4 mr-1 bg-gray-800 rounded animate-pulse"></div>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="h-4 w-12 bg-gray-800 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="h-4 w-20 bg-gray-800 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="h-4 w-12 bg-gray-800 rounded animate-pulse"></div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex space-x-1">
                                    @for ($k = 0; $k < 3; $k++)
                                        <div class="h-5 w-5 rounded-full bg-gray-800 animate-pulse"></div>
                                    @endfor
                                </div>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>

        <div class="border-t border-gray-700 px-4 py-3 flex items-center justify-between">
            <div class="h-4 w-64 bg-gray-800 rounded animate-pulse"></div>
            <div class="h-8 w-64 bg-gray-800 rounded animate-pulse"></div>
        </div>
    </div>
</div>
