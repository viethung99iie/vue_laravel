        <script setup>
        import { ref, onMounted, computed, onBeforeMount, onBeforeUnmount } from 'vue';
        import { useStore } from 'vuex'
        import { useRouter } from 'vue-router'
        import bus from '@/events/EventBus'
        import Switch from '@/components/Switch.vue';
        import axios from '@/config/axios';
        import { toast } from 'vue3-toastify';

        const store = useStore()
        const router = useRouter()

        const { tableConfig, endpoint, model, actions } = defineProps(['tableConfig', 'endpoint', 'model', 'actions'])

        const tableData = computed(() => {
            return store.getters['pagination/getTableData']
        })

        const pagination = computed(() => {
            return store.getters['pagination/getPagination']
        })

        const allChecked = ref(false)
        const selectedRow = ref([])
        const field = ref({
            publish: 'publish',
        })

        onBeforeMount(() => {
            renderData()
        })

        onMounted(() => {
            emitSearch()
            deleteMultiple()
            setStatus()
        })

        const renderData = async (page, query) => {
            try {
                let currentPage = page
                let dispatchQuery = query || {}
                if (!currentPage) {
                    const queryPage = router.currentRoute.value.query.page
                    currentPage = queryPage || 1
                }
                if (!query) {
                    dispatchQuery = { ...router.currentRoute.value.query }
                    delete dispatchQuery.page
                }

                await store.dispatch('pagination/getData', { page: currentPage, endpoint: endpoint, query: dispatchQuery })


                /* HANDLE QUERY STRING */
                const hasQueryData = dispatchQuery && Object.keys(dispatchQuery).length !== 0
                const hasPageData = currentPage !== undefined && currentPage !== ''
                if (hasQueryData || hasPageData) {
                    const queryString = {}
                    if (hasPageData) {
                        queryString.page = currentPage
                    }
                    if (hasQueryData) {
                        Object.assign(queryString, dispatchQuery)
                    }
                    /* router.push({ query: queryString }) */

                }
            } catch (error) {
                console.log(error);
            }
        }


        const emitSearch = () => {
            bus.on('table-search', searchData => {
                const searchPage = 1;
                renderData(searchPage, searchData)
            })
        }


        const deleteMultiple = async () => {
            bus.off('delete-row')
            bus.on('delete-row', async data => {
                const ids = selectedRow.value.map(index => tableData.value[index].id)
                if (ids.length === 0) {
                    toast.error('Bạn phải chọn ít nhất 1 bản ghi để xóa')
                    return
                }
                if (window.confirm('Bạn có chắc chắn muốn thực hiện thao tác này')) {
                    try {
                        const apiUrl = `${actions.deleteAll}?ids=${ids.join(',')}`
                        const response = await axios.delete(apiUrl)
                        await store.dispatch('pagination/deleteRows', ids)
                        selectedRow.value = []
                        toast.success(response.message)
                    } catch (error) {
                        console.log(error);
                    }
                }
            })
        }

        const setStatus = async () => {
            bus.off('set-status-all')
            bus.on('set-status-all', async data => {
                const ids = selectedRow.value.map(index => tableData.value[index].id)
                try {
                    const response = await axios.put(actions.updateStatusAll, { ids: ids, model: model, field: data.field, value: data.value })
                    selectedRow.value = []
                    updateSwitchStatus(ids, data.value)
                    toast.success(response.messages)

                } catch (error) {
                    console.log(error);
                }

            })
        }


        const updateSwitchStatus = (ids, value) => {
            ids.forEach(id => {
                if (switchState.value.hasOwnProperty(id)) {
                    switchState.value[id] = value === 2;
                }
            });
        };

        const switchState = computed(() => {
            const state = {};
            tableData.value.forEach(item => {
                state[item.id] = item.publish === 2;
            });
            return state;
        });

        const getRowStatus = (id) => {
            return switchState.value ? switchState.value[id] || false : false;
        };

        const checkAll = () => {
            if (allChecked.value) {
                selectedRow.value = tableData.value.map((_, index) => index)
            } else {
                selectedRow.value = []
            }
        }

        const isChecked = (key) => {
            return selectedRow.value.includes(key)
        }

        const updateCheckAll = (event, key) => {
            const totalRow = tableData.value.length
            allChecked.value = (totalRow === selectedRow.value.length) ? true : false;
        }

        onBeforeUnmount(() => {
            store.dispatch('pagination/clearData')
        })
</script>
        <template>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox"
                                class="input-checkbox check-box-item"
                                v-model="allChecked" @change="checkAll">
                        </th>
                        <td v-for="(val, index) in tableConfig.field.thead"
                            :key="index"
                            :class="tableConfig.field.class[index]"> {{
                                val }} </td>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="tableData.length > 0">
                        <tr v-for="(val, key) in tableData" :key="key"
                            :class="(selectedRow.includes(key)) ? 'selected-row' : ''"
                            @change="updateCheckAll()">
                            <td>
                                <div class="uk-flex uk-flex-center">
                                    <input type="checkbox"
                                        class="input-checkbox check-box-item "
                                        v-model="selectedRow" :value="key">
                                </div>
                            </td>
                            <td v-for="(field, index) in tableConfig.field.value"
                                :key="index"
                                :class="tableConfig.field.class[index]">{{
                                    val[field] }}</td>
                            <td>
                                <Switch :checked="getRowStatus(val.id)"
                                    :id=val.id :field="field.publish"
                                    :model="model" />
                            </td>
                            <td class="uk-flex-center text-center uk-flex">
                                <router-link :to="tableConfig.route.update + '/' +
                                    val.id" class="btn btn-primary mr10">
                                    <i class="bx bx-edit"></i>
                                </router-link>
                                <RouterLink :to="tableConfig.route.delete + '/' +
                                    val.id" class="btn btn-danger mr10">
                                    <i class="bx bx-trash-alt"></i>
                                </RouterLink>
                                <template v-if="tableConfig.action.length > 0">
                                    <RouterLink
                                        v-for="(action, actionIndex) in tableConfig.action"
                                        :key="actionIndex" :to=action.route
                                        class="btn" :class="action.color">
                                        <i :class="action.icon"></i>
                                    </RouterLink>
                                </template>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
            <div class="paginate"
                v-if="tableData.length > 0 && tableData !== null">
                <ul class="uk-pagination uk-flex-center" uk-margin>
                    <li><a href="#"><span uk-pagination-></span></a></li>
                    <li v-for="(val, index) in pagination.links" :key="index"
                        :class="{ 'uk-active': val.active }"
                        @click="renderData(val.label)">
                        <span v-if="!isNaN(val.label)">{{ val.label
                            }}</span>
                    </li>

                    <li><a href="#"><span></span></a></li>
                </ul>
            </div>
        </template>
<style scoped>
.selected-row {
    background: #ffc !important;
}

.uk-pagination li:not(:last-child) {
    margin-right: 5px;
}

.uk-pagination span {
    cursor: pointer;
    background: #eaeaea;
}

.uk-pagination li.uk-active span {
    background: var(--secondary-color);
    color: #fff
}
</style>
