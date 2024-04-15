    // Trong file "@/store/index.js"
    import { createStore } from 'vuex';

    import authStore from '@/store/auth/auth.js'
    import langStore from '@/store/lang'
    import messageStore from '@/store/message';
    import paginationStore from '@/store/pagination';
    export const store = createStore({
        modules:{
            auth : authStore,
            lang : langStore,
            message : messageStore,
            pagination: paginationStore
        }
    })

