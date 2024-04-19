        <script setup>
        import { ref, computed, onMounted } from 'vue'
        import { useStore } from 'vuex'
        import csrf from '@/config/csrf'
        import { useRouter } from 'vue-router'
        import bus from '@/events/EventBus.js'
        import axios from '@/config/axios'
        import { handleFormError } from '@/helpers/helpers'
        import Switch from '@/components/Switch.vue'
        import { defineProps } from '@vue/runtime-dom';
        import { toast } from 'vue3-toastify';

        const { tableConfig, endpoint, model, actions } = defineProps(['tableConfig', 'endpoint', 'model', 'actions'])

        const formErrorMessage = ref({});

        const store = useStore();
        const router = useRouter()

        let allChecked = ref(false);
        let selectedRow = ref([]);
        let switchItems = ref({});


        const field = ref({
            publish: 'publish',
        })

        const tableData = computed(() => {
            return store.getters['pagination/getTableData'];
        })

        const pagination = computed(() => {
            return store.getters['pagination/getPagination'];
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

                switchItems.value = switchState;

                /* HANDEL QUERT STRING  */
                const hasQueryData = dispatchQuery && Object.keys(dispatchQuery).length !== 0;
                const hasPageData = currentPage !== undefined && currentPage !== '';

                if (hasQueryData || hasPageData) {
                    const queryString = {}
                    if (hasPageData) {
                        queryString.page = currentPage
                    }
                    if (hasQueryData) {
                        Object.assign(queryString, dispatchQuery)
                    }
                    router.push({ query: queryString })
                }

            } catch (error) {
                handleFormError(error, formErrorMessage)
            }
        }
        const checkAll = () => {
            if (allChecked.value) {
                selectedRow.value = tableData.value.map((_, index) => index)
            } else {
                selectedRow.value = []
            }
        }
        const updateCheckAll = () => {
            const totalRow = tableData.value.length
            allChecked.value = (selectedRow.value.length == totalRow) ? true : false;
        }

        const emitSearch = () => {
            bus.on('table-search', searchData => {
                const searchPage = 1;
                renderData(searchPage, searchData)
            })
        }
        const deleteMultiple = () => {
            bus.off('delete-row');
            bus.on('delete-row', async data => {
                const ids = selectedRow.value.map((index) => tableData.value[index].id);
                if (ids.length == 0) {
                    toast.error('Phải chọn 1 bản ghi để thực hiện thao tác.'); return;
                }
                if (window.confirm('Bạn có chắc chắn muốn thực hiện thao tác này?')) {
                    try {
                        const apiUrl = `${actions.deleteAll}?ids=${ids.join(',')}`;
                        const response = await axios.delete(apiUrl);
                        await store.dispatch('pagination/deleteRows', ids)
                        selectedRow.value = [];
                        toast.success(response.message);
                    } catch (error) {
                        console.log(error);
                    }
                }
            })
        }
        const setStatus = () => {
            bus.off('set-status-all');
            bus.on('set-status-all', async data => {
                const ids = selectedRow.value.map((index) => tableData.value[index].id);
                if (ids.length == 0) {
                    toast.error('Phải chọn 1 bản ghi để thực hiện thao tác.'); return;
                }
                try {
                    const response = await axios.put(actions.updateStatusAll, {
                        ids: ids,
                        field: data.field,
                        model: model,
                        value: data.value
                    });
                    updatetSwitchStatus(ids, data.value);
                    selectedRow.value = [];
                    toast.success(response.messages);
                } catch (error) {
                    console.log(error);
                }
            })
        }

        const updatetSwitchStatus = (ids, value) => {
            ids.forEach(id => {
                if (switchItems.value.hasOwnProperty(id)) {
                    switchItems.value[id] = value === 2;
                }
            })
        }

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
        onMounted(() => {
            renderData();
            emitSearch();
            deleteMultiple();
            setStatus();
        })
</script>
        <template>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox"
                                class="input-checkbox check-box-item"
                                v-model="allChecked" @change="checkAll()">
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
