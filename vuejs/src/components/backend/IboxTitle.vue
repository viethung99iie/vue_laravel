    <script setup>
    import { ref } from 'vue';
    import bus from '@/events/EventBus'
    const { tableTitle } = defineProps(['tableTitle'])

    const deleteMutiple = async () => {
        bus.emit('delete-row');
    }
    const setStatus = async (field, value) => {
        bus.emit('set-status-all', { field, value });
    }

    </script>
    <template>
        <div class="ibox-title">
            <div class="uk-flex uk-flex-middle uk-flex-between">
                <h5>{{ tableTitle }}</h5>
                <div class="uk-flex uk-flex-middle cog-text">
                    <span class="widget-icon rotate">
                        <i class="bx bx-cog"></i>
                    </span>
                    <span class="text">Tác vụ nâng cao</span>
                </div>
                <div class="core-dropdown" uk-dropdown="mode: click">
                    <ul class="uk-list uk-clearfix">
                        <li @click="deleteMutiple">
                            <div class="uk-flex uk-flex-middle">
                                <i class='bx bxs-trash-alt'></i>
                                <div class="text">Xóa toàn bộ</div>
                            </div>
                        </li>
                        <li @click="setStatus('publish', 2)">
                            <div class="uk-flex uk-flex-middle">
                                <i class='bx bx-check'></i>
                                <div class="text">Publish Toàn bộ</div>
                            </div>
                        </li>
                        <li @click="setStatus('publish', 1)">
                            <div class="uk-flex uk-flex-middle">
                                <i class='bx bx-x'></i>
                                <div class="text">UnPublish Toàn bộ</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </template>
