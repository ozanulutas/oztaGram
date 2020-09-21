<template>
    <div>
        <button class="btn btn-primary ml-4" @click="followUser" v-text="buttonText"></button>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'follows'],

        mounted() {
            console.log('Component mounted.')
        },

        // status'un, kullanıcnın belirli bir profile attach veya detach olup olmadığını belirten 
        // bir default initial state'e ihtiyacı var. Bunu view'daki <follow-button>'dan geçireceğiz.
        data: function() {
            return {
                status: this.follows,
            }
        },

        methods: {
            followUser() {
                axios.post('/follow/' + this.userId)
                    .then(response => { // if success
                        this.status = !this.status;

                        console.log(response.data);
                    })
                    .catch(errors => {
                        if(errors.response.status == 401) {
                            window.location = '/login';
                        }
                    });
            }
        }, 

        computed: {
            buttonText() {
                return (this.status) ? 'Unfollow' : 'Follow';
            }
        }
    }

    
</script>
