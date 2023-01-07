<?php

/**
 * archivo que tiene las mensajes genericos de respuesta
 */

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

trait ApiResponse
{
   private function succesResponse($data, $code)
   {
      return response()->json($data, $code);
   }

   protected function errorResponse($message, $code)
   {
      return response()->json(['error' => $message, 'code' => $code], $code);
   }

   protected function showAll(Collection $collection, $code = 200)
   {

      $collection = $this->sortData($collection);
      $collection = $this->filterData($collection);
      $collection = $this->paginate($collection);
      
      return $this->succesResponse(['data' => $collection], $code);
   }

   protected function showOne(Model $collection, $code = 200)
   {
      return $this->succesResponse(['data' => $collection], $code);
   }

   public function errorMessage($message, $code)
   {
      return response($message, $code)->header('Content-type', 'aplication/json');
   }
   protected function sortData(Collection $collection)
   {
      if (request()->has('sort_by')) {
         $attribute = request()->sort_by;
         $collection = $collection->sortby->{$attribute};
      }

      return $collection;
   }

   /**
    * Con este  metodo hago los filtros
   */ //http://localhost:8080/apirestjl/public/api/User?name=alejandra leon leyva
   protected function filterData(Collection $collection)
   {
      foreach (request()->query() as $query => $value) {
         $collection = $collection->where($query, $value);
      }
      return $collection;
   }

  protected function paginate(Collection $collection)
  {
   $page = PaginationLengthAwarePaginator::resolveCurrentPage();
   $perPage = 15;
   $result = $collection->slice(($page -1) * $perPage,$perPage)->values();
   $paginated = new PaginationLengthAwarePaginator($result,$collection->count(),$perPage,$page);
   //$paginated->appends((request()->all));
   return $paginated;

  }
  
}
