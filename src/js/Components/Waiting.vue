<template>
    <div>
        <filter-nav></filter-nav>
        <speaker @fetch="fetch" :eventSpeechOrganizer="eventSpeechOrganizer"></speaker>
    </div>
</template>
<script>
import Speaker from './Speaker.vue'
import FilterNav from './FilterNav.vue'
export default {
    name: 'Waiting',
    data() {
        return {
            eventSpeechOrganizer: [],
        }
    },
    components: {
        Speaker,
        FilterNav
    },
    methods: {
        fetch() {
            this.$get({
                action: 'event_speech_organizer_admin_ajax',
                route: 'get_data',
                options: {
                    status: ['waiting']
                }
            }).then(response => {
                this.eventSpeechOrganizer = response.data
            })
        }
    },
    mounted() {
        this.fetch()
    },
}
</script>

