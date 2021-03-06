<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstructorCollection extends JsonResource
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	public function toArray($request)
	{
		return [
			"id" 			 => $this->id,
			"username" => $this->username,
			"email"		 => $this->email,
			"created_at" => $this->created_at,
			"updated_at" => $this->updated_at,
			"instructor" => $this->instructor,
			"subjects"	 => $this->instructor->subjects
		];
	}
}