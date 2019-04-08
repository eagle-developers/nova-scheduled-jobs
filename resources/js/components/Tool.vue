<template>
    <div>
        <heading class="mb-6">Scheduled Tasks</heading>

        <div class="flex justify-between">
            <div class="relative h-9 flex items-center mb-6">
                <icon type="search" class="absolute ml-3 text-70" />

                <input v-model="search"
                       class="appearance-none form-control form-input w-search pl-search"
                       placeholder="Search"
                       type="search"
                >
            </div>
        </div>

        <card class="h-auto mb-4 overflow-x-auto">
            <loader v-if="! loaded" class="my-4"></loader>
            <table v-else class="table w-full">
                <thead>
                    <tr>
                        <th class="text-left">
                            <sortable-icon
                                @sort="sortBy('command', true)"
                                uri-key="command"
                            >
                                Command
                            </sortable-icon>
                        </th>
                        <th class="text-left">Description</th>
                        <th class="text-left">Expression</th>
                        <th class="text-left">Schedule</th>
                        <th class="text-left">
                            <sortable-icon
                                @sort="sortBy('nextRunAt', true)"
                                uri-key="nextRunAt"
                            >
                                Next Run At
                            </sortable-icon>
                        </th>
                        <th class="text-left">Without Overlapping</th>
                        <th class="text-left">On One Server</th>
                        <th class="text-left">Run In Maintenance Mode</th>
                        <th class="text-left">Dispatch</th>
                    </tr>
                </thead>
                <tbody v-if="filteredTasks.length">
                    <tr v-for="(task, index) in filteredTasks">
                        <td>{{ task.command }}</td>
                        <td class="py-2">{{ task.description }}</td>
                        <td>{{ task.expression }}</td>
                        <td class="py-2">{{ task.humanReadableExpression }}</td>
                        <td>{{ formatNextRunAt(task.nextRunAt) }}</td>
                        <td class="text-center">{{ task.withoutOverlapping ? 'Yes' : 'No' }}</td>
                        <td class="text-center">{{ task.onOneServer ? 'Yes' : 'No' }}</td>
                        <td class="text-center">{{ task.evenInMaintenanceMode ? 'Yes' : 'No' }}</td>
                        <td class="text-center">
                            <button
                                title="Dispatch"
                                class="appearance-none mr-3"
                                :class="canDispatchCommand(task.command) ? 'text-70 hover:text-primary' : 'cursor-default text-40'"
                                :disabled="! canDispatchCommand(task.command)"
                                @click.prevent="openConfirmationModal(task)"
                            >
                                <icon type="play" />
                            </button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="9" class="p-4 text-center">No scheduled tasks found.</td>
                    </tr>
                </tbody>
            </table>
            <portal to="modals">
                <transition name="fade">
                    <dispatch-job-modal
                        v-if="confirmDispatchJobModal"
                        @confirm="confirmDispatchJob"
                        @close="confirmDispatchJobModal = false"
                        :command="dispatchJob.command"
                    />
                </transition>
            </portal>
        </card>
    </div>
</template>

<script>
    import formatters from '../mixins/formatters'

    export default {
        mixins: [formatters],

        data: () => ({
            confirmDispatchJobModal: false,
            dispatchJob: null,
            loaded: false,
            search: '',
            sort: {
                field: 'nextRunAt',
                order: 1,
            },
            tasks: [],
        }),

        computed: {
            filteredTasks() {
                if (this.sort.field != '') {
                    this.sortBy(this.sort.field)
                }

                if (! this.search.length) {
                    return this.tasks;
                }

                const regex = this.searchRegex;

                // User input is not a valid regular expression, show no results
                if (! regex) {
                    return {};
                }

                return this.tasks.filter(route => {
                    let matchesSearch = false;

                    for (let key in route) {
                        if (Array.isArray(route[key])) {
                            route[key].forEach(property => {
                                if (regex.test(property)) {
                                    matchesSearch = true;
                                }
                            });
                        }
                        else if (regex.test(route[key])) {
                            matchesSearch = true;
                        }
                    }

                    return matchesSearch;
                });
            },

            searchRegex() {
                try {
                    return new RegExp('(' + this.search + ')','i');
                } catch (e) {
                    return false;
                }
            }
        },

        mounted() {
            this.fetchTasks()
        },

        methods: {
            canDispatchCommand(command) {
                if (command) {
                    return command.includes("\Jobs")
                }

                return false;
            },

            confirmDispatchJob() {
                const job = this.dispatchJob
                Nova.request().post('/nova-vendor/eagle-developers/nova-scheduled-tasks/dispatch-job', { command: job.command })
                    .then((response) => {
                        this.confirmDispatchJobModal = false
                        this.$toasted.show('The job was dispatched!', { type: 'success' })
                    }).catch((error) => {
                        this.confirmDispatchJobModal = false
                        this.$toasted.show(error.response.data.message, { type: 'error' })
                    })
            },

            fetchTasks() {
                Nova.request().get('/nova-vendor/eagle-developers/nova-scheduled-tasks/tasks').then((response) => {
                    this.tasks = response.data
                    this.loaded = true

                    setTimeout(this.fetchTasks, 60 * 1000)
                })
            },

            openConfirmationModal(task) {
                this.dispatchJob = task
                this.confirmDispatchJobModal = true
            },

            sortBy(field, flip = false) {
                if (flip && field == this.sort.field) {
                    this.sort.order *= -1;
                }

                if (field != this.sort.field) {
                    this.sort.order = 1;
                }

                this.sort.field = field;

                this.tasks.sort((task1, task2) => {
                    let comparison = 0;

                    if (task1[this.sort.field] < task2[this.sort.field]) {
                        comparison = -1;
                    }

                    if (task1[this.sort.field] > task2[this.sort.field]) {
                        comparison = 1;
                    }

                    return comparison * this.sort.order;
                });
            },
        }
    }
</script>
