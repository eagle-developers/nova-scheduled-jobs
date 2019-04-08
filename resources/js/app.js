Nova.booting((Vue, router) => {
    Vue.component('nova-scheduled-tasks', require('./components/Card'))
    Vue.component('dispatch-job-modal', require('./components/DispatchJobModal'))

    router.addRoutes([{
        name: 'NovaScheduledTasks',
        path: '/scheduled-tasks',
        component: require('./components/Tool'),
    }, ])
})
