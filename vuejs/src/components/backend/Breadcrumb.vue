<script setup>
   import { ref } from 'vue';
   const { pageTitle } = defineProps(['pageTitle'])

</script>
<template>
   <div class="row wrapper border-bottom white-bg page-heading">
      <div class="page-breadcrumb">
         <h2>{{ pageTitle }}</h2>
         <ul class="breadcrumb uk-flex uk-flex-middle uk-list uk-clearfix">
            <li>
               <router-link to="/dashboard">Dashboard</router-link>
            </li>
            <li class="active"><strong>{{ pageTitle }}</strong></li>
         </ul>
      </div>
     
   </div>
</template>

<style scoped>

   .page-breadcrumb{
      padding:20px 20px;
      background: #fff;
      border-bottom:1px solid #e7eaec;
   }

   .page-breadcrumb h2{
      font-size:24px;
      margin-bottom:10px;
   }
   .page-breadcrumb ul {
      margin:0;
   }
   .page-breadcrumb ul > li{
      margin:0;
      position: relative
   }
   .page-breadcrumb ul > li > *{
      color:#333;
   }
   .page-breadcrumb ul > li:not(:last-child){
      margin-right: 10px;
      padding-right:10px;
   }

   .page-breadcrumb ul > li:not(:last-child):before{
      content:'/';
      display: block;
      position: absolute;
      right:-2px;
      top:0;
   }


</style>