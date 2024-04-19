    <script setup>
    import { ref, onMounted, onBeforeUnmount } from 'vue'
    import Layout from '@/components/backend/Layout.vue'
    import Breadcrumb from '@/components/backend/Breadcrumb.vue'
    import axios from '@/config/axios.js'
    import csrf from '@/config/csrf'
    import { useRouter } from 'vue-router'
    import { useStore } from 'vuex'
    import DeleteForm from '@/components/backend/DeleteForm.vue'


    const router = useRouter();
    const store = useStore();
    const pageTitle = ref('Xóa nhóm thành viên');
    const redirect = ref('user.catalogue.index')
    const id = router.currentRoute.value.params.id;

    const endpoint = ref('user/catalogue/delete');

    let object = ref({});

    const getData = async () => {
        try {
            await csrf.getCookie();
            const response = await axios.get('user/catalogue/' + id);
            object.value = response.data;
        } catch (error) {
            if (error.response.status == 404) {
                router.push({ name: redirect.value });
            }
        }
    }

    onMounted(() => {
        getData();
    })

</script>

    <template>
        <Layout>
            <template #template>
                <Breadcrumb :pageTitle="pageTitle" />
                <div class="page-container">
                    <DeleteForm :endpoint="endpoint" :object="object" :id="id"
                        :redirect="redirect" />
                </div>
            </template>
        </Layout>
    </template>
