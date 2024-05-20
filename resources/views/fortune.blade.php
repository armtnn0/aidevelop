@foreach ( $dateFortune as $fortune )
  <section>
    <h2>{{ $fortune['sign'] }}</h2>
    <ul>
      <li>ランク: {{ $fortune['rank'] }}</li>
      <li>内容: {{ $fortune['content'] }}</li>
      <li>ラッキーアイテム: {{ $fortune['item'] }}</li>
      <li>ラッキーカラー: {{$fortune['color']}}</li>
      <li>---------</li>
    </ul>
  </section>
  @endforeach