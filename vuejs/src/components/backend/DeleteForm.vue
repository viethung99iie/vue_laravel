<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import axios from '@/config/axios.js'
import csrf from '@/config/csrf'
import { useRouter } from 'vue-router'
import { useStore } from 'vuex'

const router = useRouter();
const store = useStore();

const { endpoint } = defineProps(['endpoint',]);

const destroy = async () => {
    const id = router.currentRoute.value.params.id;
    try {

    } catch (error) {

    }
}

</script>
<template>
    <form @submit.prevent="destroy">
        <div uk-grid>
            <div class="uk-width-2-5@m">
                <div class="panel-card">
                    <div class="panel-head">
                        Thông tin chung
                    </div>
                    <div class="panel-body">
                        <div>Thông tin chung của nhóm thành
                            viên</div>
                        <div>Lưu ý: Kiểm tra kĩ thông tin bản ghi
                            trước khi thực hiện chức năng</div>
                    </div>
                </div>
            </div>
            <div class="uk-width-3-5@m">
                <div class="ibox">
                    <div class="ibox-content">
                        <div uk-grid>
                            <div class="uk-width-1-2@m">
                                <div class="form-row">
                                    <div class="label">Tên
                                        nhóm thành viên
                                    </div>
                                    <input type="text"
                                        class="form-control form-input"
                                        readonly>
                                </div>
                            </div>
                            <div class="uk-width-1-2@m">
                                <div class="form-row">
                                    <div class="label">Mô tả</div>
                                    <input type="text"
                                        class="form-control form-input"
                                        readonly>
                                </div>
                            </div>
                        </div>
                        <div class="uk-flex uk-flex-right mt20">
                            <button class="btn btn-danger">Xóa bản
                                ghi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>
