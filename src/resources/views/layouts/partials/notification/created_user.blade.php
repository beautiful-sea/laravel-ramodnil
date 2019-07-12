<a href="{{route('users.edit',$notification->data['userCreated']['id'])}}">
	<div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
	<div class="notif-content">
		<span class="block">
			<b>{{$notification->data['createdBy']['name']}}</b>
			cadastrou um usuário
		</span>
		<span class="time"> {{date('d/m/Y H:i:s',strtotime($notification->created_at))}}</span> 
	</div>
</a>
