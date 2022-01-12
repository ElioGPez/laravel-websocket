	<template>
   		<div class="row">
		       <div class="col-8">
			   <div class="card card-default">
			       <div class="card-header">Messages</div>
			       <div class="card-body p-0">
				   <ul class="list-unstyled" style="height:300px; overflow-y:scroll" v-chat-scroll>
				       <li class="p-2" v-for="message in allMessage">
				           <strong>{{message.user.name}}</strong>
				           {{message.message}}
				       </li>
				   </ul>
			       </div>

			       <input
                   @keyup.enter="saveMessage"
                   v-model="newMessage"
				    type="text"
				    name="message"
				    placeholder="Enter your message..."
				    class="form-control">
			   </div>
			    <span class="text-muted">One User is typing...</span>
		       </div>

			<div class="col-4">
			    <div class="card card-default">
				<div class="card-header">Active Users</div>
				<div class="card-body">
				    <ul>
				        <li class="py-2">
				            Mr. X
				        </li>
				    </ul>
				</div>
			    </div>
			</div>
		   </div>
	</template>

	<script>
	    export default {
            //name : "chat",
		    props:['user'],
		    data(){
		        return{
		            allMessage:[],
		            newMessage:'',
		        }
		    },
		    created(){
		        this.getMessages();
                Echo.join('chats')
                    .listen('SendMessageEvent', (event) => {
                        this.allMessage.push(event.message);
                    })
		    },
		    methods:{
		        getMessages(){
		            axios.get('messages').then(response => {
		            this.allMessage = response.data;
                    console.log(this.user)
		            })
		        },

		        saveMessage(){
		            this.allMessage.push({
		                user:this.user,
		                message:this.newMessage
		            });
		            axios.post('messages',{message:this.newMessage});
		            this.newMessage = '';
		        },

		    }
		}
	</script>
