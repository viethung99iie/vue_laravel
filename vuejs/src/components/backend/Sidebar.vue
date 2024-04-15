<template>
    <aside id="sidebar" class="app-sidebar">
        <div class="aside-head">
            <span class="image img-cover profile-image"><img src="@/assets/backend/img/avatar-dep-dang-yeu-nu-5.jpg" alt=""></span>
            <div class="name">_Viethungw</div>
            <div class="role">Quản trị viên</div>
        </div>
        <div class="aside-body">
            <ul uk-accordion="collapsible: true" class="uk-list uk-clearfix task-list" ref="accordionElement" id="sidebar-accordion">
                <li
                    v-for="item in sidebarData"
                    :key="item.name"
                    :class="{ 'active' :  segmentInGroup(item.group) }"
                >
                    <a href="" class="uk-accordion-title">
                        <div class="uk-flex uk-flex-middle">
                            <span class="task-icon">
                                <i :class="item.icon"></i>
                            </span>
                            <span class="nav-label">{{item.name}}</span>
                        </div>
                    </a>
                    <div class="uk-accordion-content">
                        <ul v-if="item.module" class="uk-list uk-clearfix sub-module">
                            <li v-for="sub in item.module" :key="sub.name">
                                <router-link :to="sub.route">{{ sub.name }}</router-link>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
	</aside>
</template>
<script setup>
    import axios from '@/config/axios'
    import csrf from '@/config/csrf'
    import { useStore, mapGetters } from 'vuex';
    import { ref, watchEffect, onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import UIkit from 'UIkit'

    const sidebarData = ref([]);
    const store = useStore();
    const router = useRouter();

    const segment = ref(router.currentRoute.value.path.split('/')[1])
    const sidebar = store.getters['lang/getSidebar'];

    const renderSidebar = () => {
            sidebarData.value = sidebar
    }

    const segmentInGroup = (group) => {
        return group.includes(segment.value)
    }

    const toggleSidebar = () => {
        const sidebarAccordionElement = document.getElementById('sidebar-accordion')
        const liArray = Array.from(document.querySelectorAll('#sidebar-accordion > li'))

        const activeIndex = liArray.findIndex( (li) => li.classList.contains('active') )

        if(activeIndex !== -1){
            UIkit.accordion(sidebarAccordionElement).toggle(activeIndex, true)
        }
    }

    onMounted(() => {
        toggleSidebar()
    })

    watchEffect(() => {
        renderSidebar();
    })
</script>

<style scoped>

    ul >li{
        list-style-type: none;
    }
    .app-sidebar{
        height:100%;
        width: 240px;
        background: #111c43;
        color:#a3aed1;
        position: fixed;
    }
    .app-sidebar .aside-head{
        padding:20px;
    }
    .profile-image{
        width:48px;
        height:48px;
        border-radius: 50%;
        display: inline-block;
        margin-bottom:5px;
    }
    .profile-image img{
        border-radius: 50%;
    }
    .aside-head .name{
        font-weight: 500;
        color:#fff;
        margin-bottom:7px;
    }
    .aside-head .role{
        font-size:13px;
    }

    .app-sidebar .aside-body{
        padding:0 10px;
    }

    .app-sidebar .task-list{
        margin:0;
    }
    .app-sidebar .task-list > li > a{
        padding: 13px 12px;
        position: relative;
        text-decoration: none;
        font-size:13px;
        border-radius: 8px;
        display: block;
        color:#a3aed1;
        position: relative;
        padding-left:40px;
        font-weight: 500;
    }

    .app-sidebar .task-list  a:hover,
    .app-sidebar .task-list > li > a.active{
        background: rgba(255,255,255,.05);
        color:#fff;
        border-radius: 8px;
    }
    .app-sidebar .task-list li:hover > a,
    .app-sidebar .task-list li .active >  a{
        color:#fff;
    }
    .app-sidebar .task-list li > a .task-icon{
        font-size:18px;
        position: absolute;
        top:10px;
        left:10px;
    }
    .app-sidebar .uk-accordion-content{
        margin:0;
    }

    .app-sidebar .uk-accordion>:nth-child(n+2){
        margin-top:0;
    }

    .app-sidebar .task-list li > a .task-icon:before{
        content:'';
    }
    .app-sidebar .task-list li > a .arrow{
        right:10px;
        left:initial
    }
    .task-name{
        text-transform: uppercase;
        color:#57638b !important;
        font-weight:700 !important;
        font-size:11px !important;
        padding-left:10px !important;
    }

    .sub-module{
        padding-left:20px;
        margin:0;
    }
    .sub-module.active{
        max-height:1000px;
    }
    .sub-module li {
        margin:0;
    }
    .sub-module li > a{
        font-size:13px;
        color:#a3aed1;
    }
    .sub-module li > a{
        position: relative;
        padding:8px 10px 8px 18px;
        display: block;
    }
    .sub-module li > a:before{
        content:'';
        display: block;
        position: absolute;
        left:8px;
        top:16px;
        width:5px;
        height:5px;
        background: transparent;
        border:1px solid #a3aed1;
        border-radius: 50%;
    }
    .sub-module li > a:hover{
        background: rgba(255,255,255,.05);
        border-radius: 8px;
    }

    .uk-accordion-title::before{
        width:10px;
        height:9px;
        filter: brightness(0) invert(1);
        position: absolute;
        top:18px;
        right:10px;
    }
    .uk-accordion-title::before{
        background-image: url(@/assets/backend/img/chevron-right-regular-24.png);
        background-size:100%;
    }
    .uk-open>.uk-accordion-title:before{
        background-image: url(@/assets/backend/img/chevron-down-regular-24.png);
        background-size:100%;
    }

    .uk-accordion-title:before{
        width:17px;
        height:17px;
        top:14px;
    }
</style>
