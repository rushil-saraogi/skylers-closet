<template>
    <div class="flex justify-center items-center">
        <div class="loader ease-linear rounded-full border-2 border-t-2 border-gray-200 h-5 w-5"></div>
    </div>  
</template>

<script>
</script>

<style scoped>
  .loader {
    border-top-color: #3498db;
    -webkit-animation: spinner 1.5s linear infinite;
    animation: spinner 1.5s linear infinite;
  }
  
  @-webkit-keyframes spinner {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }
  
  @keyframes spinner {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>