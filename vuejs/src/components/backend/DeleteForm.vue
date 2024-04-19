    <script setup>
    import { ref, onMounted, onBeforeUnmount } from 'vue'
    import axios from '@/config/axios.js'
    import csrf from '@/config/csrf'
    import { useRouter } from 'vue-router'
    import { useStore } from 'vuex'
    import { toast } from 'vue3-toastify';

    const router = useRouter();
    const store = useStore();

    const { endpoint, object, id, redirect } = defineProps(['endpoint', 'object', 'id', 'redirect']);

    const destroy = async () => {
        if (window.confirm('Bạn có chắc chắn muốn thực hiện thao tác này?')) {
            try {
                await csrf.getCookie();
                const response = await axios.delete(endpoint + '/' + id);
                await store.dispatch('message/showMessage', { message: response.message, type: 'success' })
                router.push({ name: redirect });
            } catch (error) {
                console.log(error);
            }
        } else {
            toast.error('Thao tác đã được hủy bỏ.'); return;
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
                                            :value="object.name" readonly>
                                    </div>
                                </div>
                                <div class="uk-width-1-2@m">
                                    <div class="form-row">
                                        <div class="label">Mô tả</div>
                                        <input type="text"
                                            class="form-control form-input"
                                            :value="object.description"
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
