<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Models\Book\BookModel;
use Illuminate\Http\Request;
use App\Http\Services\Book\BookService;
use App\Http\Resources\Book\BookResource;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    //
    private $bookService;


    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }



    /**
     * @OA\Get(
     *      path="/book/get/all",
     *      operationId="getBookAll",
     *      tags={"BOOK"},
     *      summary="Get all books list ",
     *      description="Get all books list from database",
     *
     *
     *
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found!"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *     )
     */
    public function getBookAll(Request $request)
    {
        $books = BookModel::all();

        return BookResource::collection($books);
    }


    /**
     * @OA\POST(
     * path="/book/get/all/paginated",
     * summary="book list paginated",
     * description="get paginated book list form database",
     * operationId="getBookPaginated",
     * tags={"BOOK"},
     *
     *
     * @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="perPage", type="string", example="15"),
     *              @OA\Property(property="page", type="string", example="1"),
     *
     *          ),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *
     *                 @OA\Property(
     *                      property="perPage",
     *                      description="number of customer per page",
     *                      type="text",
     *                  ),
     *                  @OA\Property(
     *                      property="page",
     *                      description="page number",
     *                      type="text",
     *                  ),
     *
     *
     *               ),
     *           ),
     *       ),
     *
     *
     *       @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *
     * )
     *
     */
    public function getBookPaginated(Request $request)
    {
        $perPage = $request->perPage;
        $books = BookModel::paginate($perPage, ['*'], 'page');

        return BookResource::collection($books);
    }


    /**
     * @OA\Get(
     *      path="/book/details/{id}",
     *      operationId="getBookDetails",
     *      tags={"BOOK"},
     *      summary="Get book Details details",
     *      description="Get book details from database",
     *
     *
     *       @OA\Parameter(
     *         description="ID of Book to return",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Not Found!"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *     )
     */
    public function getBookDetails(Request $request)
    {
        //fetch
        $book =   BookModel::findOrFail($request->id);

        return BookResource::make($book);
    }

    /**
     * @OA\POST(
     * path="/book/insert",
     * summary="insert book into databsae",
     * description="insert  book into databsae",
     * operationId="bookInsert",
     * tags={"BOOK"},
     *
     *
     * @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="name", type="string", example="BOOK1"),
     *              @OA\Property(property="price", type="string", example="10"),
     *
     *          ),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *
     *                  @OA\Property(
     *                      property="name",
     *                      description="name of the book",
     *                      type="text",
     *
     *                   ),
     *
     *                  @OA\Property(
     *                      property="price",
     *                      description="price of the book",
     *                      type="text",
     *
     *                   ),
     *
     *
     *               ),
     *           ),
     *       ),
     *
     *
     *       @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *
     * )
     *
     */
    public function bookInsert(Request $request)
    {
        //validate
        $this->bookService->validateBookInsertRequest($request);

        //insert
        $book = $this->bookService->insertBook($request);
        //response
        return BookResource::make($book);
    }


    /**
     * @OA\POST(
     * path="/book/update",
     * summary="update a book into databsae",
     * description="update book into databsae",
     * operationId="bookUpdate",
     * tags={"BOOK"},
     *
     *
     * @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="id", type="string", example="1"),
     *              @OA\Property(property="name", type="string", example="BOOK1"),
     *              @OA\Property(property="price", type="string", example="10"),
     *
     *          ),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *
     *                  @OA\Property(
     *                      property="id",
     *                      description="id of book which will be updated",
     *                      type="text",
     *
     *                   ),
     *
     *                  @OA\Property(
     *                      property="name",
     *                      description="name of the book",
     *                      type="text",
     *
     *                   ),
     *
     *                  @OA\Property(
     *                      property="price",
     *                      description="price of the book",
     *                      type="text",
     *
     *                   ),
     *
     *
     *               ),
     *           ),
     *       ),
     *
     *
     *       @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *
     * )
     *
     */
    public function bookUpdate(Request $request)
    {
        //validate
        $this->bookService->validateBookUpdateRequest($request);
        //fetch
        $book = BookModel::findOrFail($request->id);
        //update
        $updatedBook =  $this->bookService->updateBook($request, $book);

        return BookResource::make($updatedBook);
    }

    /**
     * @OA\POST(
     * path="/book/delete",
     * summary="delete a book from databsae",
     * description="delete book from databsae",
     * operationId="bookDelete",
     * tags={"BOOK"},
     *
     *
     * @OA\RequestBody(
     *          required=true,
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="id", type="string", example="1"),
     *
     *
     *          ),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *
     *                  @OA\Property(
     *                      property="id",
     *                      description="id of book which will be updated",
     *                      type="text",
     *
     *                   ),
     *
     *
     *               ),
     *           ),
     *       ),
     *
     *
     *       @OA\Response(
     *          response=204,
     *          description="Successful Delete operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity"
     *      ),
     *
     * )
     *
     */
    public function bookDelete(Request $request)
    {
        $this->bookService->validateBookDeleteRequest($request);
        //fetch
        $book = BookModel::findOrFail($request->id);

        $book->delete();

        return new JsonResponse([], 204);
    }
}
