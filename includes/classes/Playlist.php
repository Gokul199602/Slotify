<?php 
	Class Playlist
	{
		private $con;
		private $name;
		private $id;
		private $data;
		private $owner;


		function __construct($con,$data)
		{
			if(!is_array($data))
			{
				$query = mysqli_query($con, "SELECT * FROM playlists WHERE id = '$data'");
				$data = mysqli_fetch_array($query);
			}
			$this->con = $con;
			$this->name = $data['name'];
			$this->id = $data['id'];
			$this->owner = $data['owner'];
		}

		public function getName()
		{
			return $this->name; 
		}
		public function getId()
		{
			return $this->id; 
		}
		public function getOwner()
		{
			return $this->owner; 
		}
		public function getNumSongs()
		{
			$query = mysqli_query($this->con, "SELECT * FROM playlistSongs WHERE  playlistId = '$this->id'");
			return mysqli_num_rows($query); 
		}
		public function getSongIds()
		{
			$queryId = mysqli_query($this->con,"Select songid from playlistsongs where playlistId = '$this->id' ORDER BY playlistorder ASC");

			$array = array();

			while($row = mysqli_fetch_array($queryId))
			{
				array_push($array, $row['songid']);
				
			}

			return $array;
		}

		public static function getPlaylistDropdown($con,$username)
		{
			$dropDown = '<select class = "item playlist">
				<option value="">Add to playlist</option>';
			$query = mysqli_query($con,"SELECT id,name FROM playlists WHERE owner = '$username'");
			while ($row = mysqli_fetch_array($query)) 
			{
				$id = $row['id'];
				$name = $row['name'];
				$dropDown = $dropDown."<option value='$id' >".$name."</option>";

			}
			return $dropDown.'</select>';
		}

	}

 ?>