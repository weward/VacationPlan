<!DOCTYPE html>
<html xmlns:th="http://www.thymeleaf.org">

<head>
	<style th:replace="inc/bootstrap :: inc"></style>

	<style>
		#header {
			display: block;
			position: running(header);
		}
		#footer {
			display: block;
			position: running(footer);
		}

		#content {
			page-break-after: always;
		}

		.pagenumber:before {
			content: counter(page);
		}

		.pagecount:before {
			content: counter(pages);
		}

		@page {
			@top-center { content: element(header) }
		}

		@page {
			@bottom-center { content: element(footer) }
		}

		@page {
			margin-bottom: 5cm;
			margin-left: 3.5cm;
			margin-right: 0.5cm;
		}
	</style>
</head>
<body>
	<div id="header">
		<h1 style="text-align:left;">Holiday Plan</h1>
        <br />
        <br />
	</div>
	<div id="content">
        <div id="footer">
            Title: <br />
            <b>{{ $data['title'] }}</b> <br />
            <br />
            Date:<br /> 
            <b>{{ $data['date'] }}</b> <br />
            Location: <b>{{ $data['location'] }}</b> <br />
            <br />
            Description: <br />
            <b>{{ $data['description'] }}</b> <br />
            <br />
            By: <br />
            <b>{{ $data['user']['name'] }}</b> <br />
            <b>{{ $data['user']['email'] }}</b> <br />
            <br />
            <br />
            @if (is_null($data['participants']) || !count($data['participants']))
            <p>There are no participants</p>
            @else 
            <b>Participants</b>
                <br />
                <br />
                @foreach ($data['participants'] as $participant)
                    {{ $participant }} <br />
                @endforeach
            @endif
        </div>
		
	</div>
</body>
</html>