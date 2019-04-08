<template>
    <card class="h-auto p-4">
        <h2 class="text-90 font-light mb-4">Scheduled Tasks</h2>

        <p v-if="! loading && ! tasks.length">You do not currently have any scheduled tasks.</p>

        <loader v-if="loading" class="mb-4"></loader>

        <table v-if="! loading && tasks.length" class="table w-full">
            <thead>
                <tr>
                    <th class="text-left">Command</th>
                    <th class="text-left">Expression</th>
                    <th class="text-left">Next Run At</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(task, index) in tasks" :task="task">
                    <td>{{ task.command }}</td>
                    <td>{{ task.expression }}</td>
                    <td>{{ formatNextRunAt(task.nextRunAt) }}</td>
                </tr>
            </tbody>
        </table>

    </card>
</template>

<script>
    import formatters from '../mixins/formatters'

    export default {
        mixins: [formatters],

        props: ['card'],

        data: () => {
            return {
                loading: false,
                tasks: [],
            }
        },

        mounted() {
            console.log('got here')
            this.fetchTasks()
        },

        methods: {
            fetchTasks() {
                this.loading = true

                Nova.request().get('/nova-vendor/eagle-developers/nova-scheduled-tasks/tasks').then((response) => {
                    this.loading = false
                    this.tasks = response.data

                    setTimeout(this.fetchTasks, 60 * 1000)
                })
            },
        }
    }
</script>
