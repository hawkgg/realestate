<template>
    <template v-if="village">
        <div class="row">
            <div class="col d-flex justify-content-between flex-nowrap">
                <router-link class="text-decoration-none d-flex align-items-center gap-1 py-3"
                             :to="{ name: 'villages.index' }">
                    <i class="fa-solid fa-chevron-left"></i> Назад
                </router-link>
                <div class="d-flex gap-2 align-items-center">
                    <router-link  v-if="user?.permissions.some(p => p.name === 'village.edit')"
                                 :to="{ name: 'villages.edit', params: { village: village.id } }"
                                  class="btn btn-primary">
                        <i class="fa-solid fa-pencil me-1"></i> Редактировать
                    </router-link>

                    <a v-if="user?.permissions.some(p => p.name === 'village.delete')"
                       @click.prevent="deleteVillage(village.id)"
                       class="btn btn-danger"
                       href="">
                        <i class="fa-solid fa-trash"></i> Удалить
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <img v-if="village.photo" class="w-100" :src="VITE_APP_URL + village.photo.path" alt="">
                <h3 v-else>Фото отсутствует</h3>
            </div>
            <div class="col-xl-8 px-xl-3">
                <p class="mb-2"><b>Название</b>: {{ village.name }}</p>
                <p class="my-2"><b>Адрес</b>: {{ village.address }}</p>
                <p class="my-2"><b>Площадь поселка (гектар)</b>: {{ village.square ?? '–' }}</p>
                <p class="my-2"><b>Горячая линия (телефон)</b>: {{ village.phone ?? '–' }}</p>
                <p class="my-2"><b>YouTube видео</b>:
                    <a v-if="village.youtube_link" target="_blank" :href="village.youtube_link">
                        {{ village.youtube_link }}
                    </a>
                    <span v-else>–</span>
                </p>

                <p v-if="village.presentation" class="my-2">
                    <b>Файл презентации (pdf)</b>:
                    <a :href="VITE_APP_URL + '/' + village.presentation.path"
                       target="_blank"
                       class="text-decoration-none">
                        {{ village.presentation.path }}
                    </a>
                </p>
            </div>
        </div>
    </template>
    <div v-else-if="loading" class="pt-5 mt-5 d-flex justify-content-center">
        <loader :loading="loading" :color="'#0d6efd'" :size="'40px'"></loader>
    </div>
    <p v-else class="mt-5 text-danger">Произошла ошибка. Пожалуйста, перезагрузите страницу или попробуйте позже.</p>
</template>

<script>
import { mapState } from 'vuex';
import VillageService from "@/services/VillageService";
import loader from 'vue-spinner/src/MoonLoader.vue';

export default {
    name: "VillagesShow",
    components: {
        loader
    },
    computed: {
        ...mapState('Main', ['user']),
    },
    data() {
        return {
            VITE_APP_URL: import.meta.env.VITE_APP_URL,
            village: null,
            loading: true,
        }
    },
    async created() {
        let res = await VillageService.getVillage(this.$route.params.village)
        this.village = res.data
        this.loading = false
        if (!this.village) {
            this.$router.push({ name: 'NotFound' })
        }
    },
    methods: {
        async deleteVillage(id) {
            await VillageService.deleteVillage(id)
            this.$router.push({ name: 'villages.index' })
        }
    },
}
</script>

<style scoped>

</style>
