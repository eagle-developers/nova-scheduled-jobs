<template>
    <div>
        <heading class="mb-4">
            Scheduled Tasks
        </heading>

        <card class="h-auto mb-4 overflow-x-auto">
            <p v-if="loaded && ! tasks.length">You do not currently have any scheduled tasks.</p>

            <loader v-if="! loaded" class="mb-4"></loader>

            <table v-if="loaded && tasks.length" class="table w-full">
                <thead>
                    <tr>
                        <th class="text-left">Command</th>
                        <th class="text-left">Description</th>
                        <th class="text-left">Schedule</th>
                        <th class="text-left">Expression</th>
                        <th class="text-left">Next Run At</th>
                        <th class="text-left">Without Overlapping</th>
                        <th class="text-left">On One Server</th>
                        <th class="text-left">Run In Maintenance Mode</th>
                        <th class="text-left">Dispatch</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(task, index) in tasks">
                        <td>{{ task.command }}</td>
                        <td class="py-2">{{ task.description }}</td>
                        <td class="py-2">{{ task.humanReadableExpression }}</td>
                        <td>{{ task.expression }}</td>
                        <td>{{ formatNextRunAt(task.nextRunAt) }}</td>
                        <td>{{ task.withoutOverlapping ? 'Yes' : 'No' }}</td>
                        <td>{{ task.onOneServer ? 'Yes' : 'No' }}</td>
                        <td>{{ task.evenInMaintenanceMode ? 'Yes' : 'No' }}</td>
                        <td>
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
            tasks: [],
            loaded: false,
            dispatchJob: null,
            confirmDispatchJobModal: false,
        }),

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

            openConfirmationModal(task) {
                this.dispatchJob = task
                this.confirmDispatchJobModal = true
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
        }
    }
</script>
