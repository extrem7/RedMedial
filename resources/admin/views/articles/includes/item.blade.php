@php
    /* @var Article $article */use App\Models\Article;
@endphp
<tr data-id="{{$article->id}}">
    <td class="text-center move"><i class="far fa-hand-rock"></i></td>
    <td>{{$article->title}}</td>
    <td>{{$article->created_at->format('d.m.Y H:i')}}</td>
    <td class="d-flex ">
        <a href="{{route('admin.articles.edit',$article->id)}}" class="btn btn-outline-primary"><i
                class="fa fa-edit"></i></a>
        <form action="{{route('admin.articles.destroy',$article->id)}}" method="post" class="form-ajax ml-2">
            @method('DELETE')
            @csrf
            <button class="btn btn-outline-danger delete"><i class="fa fa-times"></i></button>
        </form>
    </td>
</tr>
