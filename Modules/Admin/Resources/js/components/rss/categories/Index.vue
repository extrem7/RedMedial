<template>
    <div class="col-12">
        <CreateBtn/>
        <BOverlay
            :opacity="0.5"
            :show="isBusy"
            variant="dark">
            <BTable
                :fields="fields"

                :items="items"
                bordered

                dark
                hover
                ref="table">
                <template v-slot:cell(slug)="{item:{slug}}">
                    <a
                        :href="route('frontend.rss.categories.show',slug)"
                        target="_blank">
                        {{ slug }}
                    </a>
                </template>
                <template v-slot:cell(posts)="{item:{posts_count}}">
                    {{ posts_count || 0 }}
                </template>
                <template v-slot:cell(created_at)="{item:{created_at}}">
                    {{ created_at | moment("DD.MM.YYYY HH:mm") }}
                </template>
                <template v-slot:cell(updated_at)="{item:{updated_at}}">
                    {{ updated_at | moment("DD.MM.YYYY HH:mm") }}
                </template>

                <template v-slot:cell(actions)="{item:{id}}">
                    <ActionsButtons
                        :id="id"
                        :resource="resource"
                        @delete="destroy(id)"
                    />
                </template>
            </BTable>
        </BOverlay>
    </div>
</template>

<script>
import {destroy, index} from '@/mixins/index-table'

export default {
    data() {
        return {
            items: this.shared('categories'),
            resource: 'rss.categories',
            fields: [
                'id',
                'name',
                'slug',
                'posts',
                {key: 'created_at', thClass: 'date-column'},
                {key: 'updated_at', thClass: 'date-column'},
                {key: 'actions', label: '', thClass: 'actions-column'}
            ],
        }
    },
    mixins: [index, destroy]
}
</script>
