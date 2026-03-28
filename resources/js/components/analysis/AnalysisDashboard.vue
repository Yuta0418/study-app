<script setup>
import { computed, nextTick, onBeforeUnmount, onMounted, ref } from 'vue';

const props = defineProps({
    initialData: {
        type: Object,
        required: true,
    },
});

const monthlyChartRef = ref(null);
const weeklyChartRef = ref(null);
const continuityChartRef = ref(null);
const radarChartRef = ref(null);
const mockTrendChartRef = ref(null);
const subjectBreakdownChartRef = ref(null);

const chartInstances = [];

const summary = computed(() => props.initialData.summary ?? {});
const continuity = computed(() => props.initialData.continuity ?? {});
const monthly = computed(() => props.initialData.monthly ?? {});
const weekly = computed(() => props.initialData.weekly ?? {});
const radar = computed(() => props.initialData.radar ?? {});
const mockTrend = computed(() => props.initialData.mockTrend ?? {});
const subjectBreakdown = computed(() => props.initialData.subjectBreakdown ?? {});
const latestMockChartType = computed(() => ((radar.value.labels ?? []).length <= 2 ? 'bar' : 'radar'));

function createChart(canvasRef, config) {
    if (!canvasRef.value || !window.Chart) {
        return;
    }

    const instance = new window.Chart(canvasRef.value, config);
    chartInstances.push(instance);
}

function renderCharts() {
    createChart(monthlyChartRef, {
        type: 'bar',
        data: {
            labels: monthly.value.labels ?? [],
            datasets: [{
                label: '学習時間（分）',
                data: monthly.value.data ?? [],
            }],
        },
        options: {
            scales: {
                y: { beginAtZero: true },
            },
        },
    });

    createChart(weeklyChartRef, {
        type: 'line',
        data: {
            labels: weekly.value.labels ?? [],
            datasets: [{
                label: '学習時間（分）',
                data: weekly.value.data ?? [],
                tension: 0.3,
            }],
        },
        options: {
            scales: {
                y: { beginAtZero: true },
            },
        },
    });

    const continuityDays = continuity.value.weekly_days ?? [];
    const continuityColors = continuityDays.map((day) =>
        day === 1 ? 'rgba(34, 197, 94, 0.8)' : 'rgba(209, 213, 219, 0.8)'
    );

    createChart(continuityChartRef, {
        type: 'bar',
        data: {
            labels: continuity.value.labels ?? [],
            datasets: [{
                label: '学習状況',
                data: continuityDays,
                backgroundColor: continuityColors,
                borderRadius: 6,
            }],
        },
        options: {
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    callbacks: {
                        label(context) {
                            return context.raw === 1 ? '学習あり' : '学習なし';
                        },
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 1,
                    ticks: {
                        stepSize: 1,
                        callback(value) {
                            return value === 1 ? '学習あり' : '学習なし';
                        },
                    },
                },
            },
        },
    });

    if ((radar.value.labels ?? []).length > 0) {
        createChart(radarChartRef, {
            type: latestMockChartType.value,
            data: {
                labels: radar.value.labels,
                datasets: [{
                    label: 'スコア',
                    data: radar.value.data ?? [],
                    backgroundColor: latestMockChartType.value === 'bar' ? 'rgba(79, 70, 229, 0.75)' : 'rgba(79, 70, 229, 0.2)',
                    borderColor: 'rgb(79, 70, 229)',
                    borderWidth: 2,
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: latestMockChartType.value === 'radar'
                    ? {
                        r: {
                            beginAtZero: true,
                            suggestedMax: 100,
                        },
                    }
                    : {
                        y: {
                            beginAtZero: true,
                            suggestedMax: 100,
                        },
                    },
            },
        });
    }

    if ((mockTrend.value.labels ?? []).length > 0) {
        const datasets = [{
            label: '総合得点',
            data: mockTrend.value.scoreData ?? [],
            borderColor: 'rgb(79, 70, 229)',
            backgroundColor: 'rgba(79, 70, 229, 0.12)',
            fill: true,
            tension: 0.3,
        }];

        if (mockTrend.value.passingScore !== null && mockTrend.value.passingScore !== undefined) {
            datasets.push({
                label: '合格基準点',
                data: (mockTrend.value.labels ?? []).map(() => mockTrend.value.passingScore),
                borderColor: 'rgb(239, 68, 68)',
                borderDash: [6, 6],
                pointRadius: 0,
                fill: false,
                tension: 0,
            });
        }

        if (mockTrend.value.targetScore !== null && mockTrend.value.targetScore !== undefined) {
            datasets.push({
                label: '目標得点',
                data: (mockTrend.value.labels ?? []).map(() => mockTrend.value.targetScore),
                borderColor: 'rgb(16, 185, 129)',
                borderDash: [6, 6],
                pointRadius: 0,
                fill: false,
                tension: 0,
            });
        }

        createChart(mockTrendChartRef, {
            type: 'line',
            data: {
                labels: mockTrend.value.labels,
                datasets,
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: '総合得点',
                        },
                    },
                },
            },
        });
    }

    if ((subjectBreakdown.value.labels ?? []).length > 0) {
        createChart(subjectBreakdownChartRef, {
            type: 'bar',
            data: {
                labels: subjectBreakdown.value.labels,
                datasets: [{
                    label: '学習時間（分）',
                    data: subjectBreakdown.value.data ?? [],
                    backgroundColor: 'rgba(16, 185, 129, 0.75)',
                    borderRadius: 8,
                }],
            },
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        beginAtZero: true,
                    },
                },
            },
        });
    }
}

onMounted(async () => {
    await nextTick();
    renderCharts();
});

onBeforeUnmount(() => {
    chartInstances.forEach((instance) => instance.destroy());
});
</script>

<template>
    <div class="space-y-8">
        <div class="bg-gradient-to-r from-indigo-500 to-blue-500 text-white p-6 rounded-xl shadow">
            <h2 class="text-sm opacity-80 mb-1">合計学習時間</h2>
            <p class="text-4xl font-bold">
                {{ Number(summary.total_minutes ?? 0).toLocaleString() }} 分
            </p>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold mb-4">継続指標</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">連続学習日数</span>
                        <span class="text-lg font-bold text-indigo-600">{{ continuity.currentStreak }} 日</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">今週の学習日数</span>
                        <span class="text-lg font-bold text-emerald-600">
                            {{ continuity.studyDaysThisWeek }} / {{ continuity.weeklyGoal }} 日
                        </span>
                    </div>
                    <div>
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-2 bg-indigo-600 rounded-full" :style="{ width: `${continuity.achievementRate}%` }"></div>
                        </div>
                        <p class="text-right text-xs text-gray-500 mt-1">達成率 {{ continuity.achievementRate }}%</p>
                    </div>
                </div>
                <div class="mt-6" style="height: 180px;">
                    <canvas ref="continuityChartRef"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold mb-4">月別学習時間</h2>
                <canvas ref="monthlyChartRef"></canvas>
            </div>

            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold mb-4">直近7日</h2>
                <canvas ref="weeklyChartRef"></canvas>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                <h2 class="font-semibold mb-4">最新模試（科目別）</h2>

                <p v-if="!(radar.labels ?? []).length" class="text-gray-400 text-center py-10">
                    模試データがありません
                </p>
                <p v-else-if="latestMockChartType === 'bar'" class="text-sm text-gray-500 mb-3">
                    2科目以下のため、見やすい棒グラフで表示しています。
                </p>
                <div v-if="(radar.labels ?? []).length" class="flex items-center justify-center" style="height: 240px;">
                    <canvas ref="radarChartRef"></canvas>
                </div>
            </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <h2 class="font-semibold mb-4">模試推移</h2>
            <p class="text-sm text-gray-500 mb-3">総合得点に合格基準点と目標得点を重ねて表示します。</p>

            <p v-if="!(mockTrend.labels ?? []).length" class="text-gray-400 text-center py-10">
                模試データがありません
            </p>
                <div v-else style="height: 240px;">
                    <canvas ref="mockTrendChartRef"></canvas>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold">科目別学習時間</h2>
                <p class="text-sm text-gray-500">累計学習時間（分）</p>
            </div>

            <p v-if="!(subjectBreakdown.labels ?? []).length" class="text-gray-400 text-center py-10">
                学習記録がありません
            </p>
            <div v-else style="height: 240px;">
                <canvas ref="subjectBreakdownChartRef"></canvas>
            </div>
        </div>
    </div>
</template>
