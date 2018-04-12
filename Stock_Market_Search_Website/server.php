<?php
    header('Access-Control-Allow-Origin: *');
    if(isset($_GET['symbol'])) {  // stock quote
        $symbol = $_GET['symbol']; // url : http://localhost/hw8/server.php?&symbol=a
        $json_url = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=".$symbol."&apikey=NI9JHOEVZJ0M2LC4&outputsize=full";
        $contents = file_get_contents($json_url); 
        $contents = utf8_encode($contents); 
        $json_result = json_decode($contents,true);

        $metaData = $json_result["Meta Data"];
        $timeSeriesDaily = $json_result["Time Series (Daily)"];
        $timeKeys = array_keys($timeSeriesDaily);
        $currentStock = $timeSeriesDaily[$timeKeys[0]];
        $previousStock = $timeSeriesDaily[$timeKeys[1]];
        

        $json_object = array(
            "Symbol" => $metaData["2. Symbol"],
            "High" => round($currentStock["2. high"],2),
            "Low" => round($currentStock["3. low"],2),
            "Open" => round($currentStock["1. open"],2),
            "Close" => round($currentStock["4. close"],2),
            "Change" => round(($currentStock["4. close"] - $previousStock["4. close"]),2),
            "ChangePercent" => round(((($currentStock["4. close"] - $previousStock["4. close"]) / $currentStock["4. close"]) * 100),2),
            "LastPrice" => round($previousStock["4. close"],2),
            "Timestamp" => $metaData["3. Last Refreshed"],
            "Volume" => $currentStock["5. volume"]
        );

        echo json_encode($json_object,JSON_FORCE_OBJECT);        
    }
    else if(isset($_GET['input'])) { // autocomplete
        $input = $_GET['input'];  // url : http://localhost/hw8/server.php?&input=a
        $json_url_autocomplete = "http://dev.markitondemand.com/Api/v2/Lookup/json?input=$input";
        $contents_autocomplete = file_get_contents($json_url_autocomplete); 
        $contents_autocomplete = utf8_encode($contents_autocomplete); 
        $json_result_autocomplete = json_decode($contents_autocomplete);

        echo json_encode($json_result_autocomplete);
    }
    else if(isset($_GET['news'])) { // news 
        $news = $_GET['news'];      // url : http://localhost/hw8/server.php?&news=aapl
        $xml = simplexml_load_file('https://seekingalpha.com/api/sa/combined/'.$news.'.xml');
        $item = $xml->channel->item;
        $count = 0;
        $titleArray = array();
        $linkArray = array();
        $dateArray = array();
        $authorArray = array();
        foreach ($item as $n){ 
            $title = (string)$n->title;
            $link = (string)$n->link;
            $date = (string)$n->pubDate;
            $author = (string)$n->xpath('sa:author_name')[0];
            if ($link != 'https://seekingalpha.com/symbol/AAPL/news?source=feed_symbol_AAPL' and $link != 'https://seekingalpha.com'){
                $count+=1;
                if ($count > 5){
                    break;
                }else{
                    array_push($titleArray,$title);
                    array_push($linkArray,$link);
                    array_push($dateArray,$date);
                    array_push($authorArray,$author);
                }
            }else{
                continue;
            }
        }
        $response = array(
            'title' => $titleArray,
            'link' => $linkArray,
            'date' => $dateArray,
            'author'=>$authorArray
        );
        echo json_encode($response);
    }
    else if(isset($_GET['chart'])) { // chart
        $chart = $_GET['chart']; // url : http://localhost/hw8/server.php/?chart=aapl
        
        $json_url_chart = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=".$chart."&apikey=NI9JHOEVZJ0M2LC4&outputsize=full";
        $contents_chart = file_get_contents($json_url_chart); 
        $contents_chart = utf8_encode($contents_chart); 
        $json_result_chart = json_decode($contents_chart,true);

        echo json_encode($json_result_chart,JSON_FORCE_OBJECT);   
    }
    else if(isset($_GET['sma'])) { // chart
        $sma = $_GET['sma']; // url : http://localhost/hw8/server.php/?chart=aapl
        $json_url_sma = "https://www.alphavantage.co/query?function=SMA&symbol=".$sma."&interval=daily&time_period=10&series_type=close&apikey=NI9JHOEVZJ0M2LC4&outputsize=full";
        $contents_chart = file_get_contents($json_url_sma); 
        $contents_chart = utf8_encode($contents_chart); 
        $json_result_sma = json_decode($contents_chart,true);
        echo json_encode($json_result_sma,JSON_FORCE_OBJECT);   
    }
    else if(isset($_GET['ema'])) { // chart
        $ema = $_GET['ema']; // url : http://localhost/hw8/server.php/?chart=aapl
        $json_url_ema = "https://www.alphavantage.co/query?function=EMA&symbol=".$ema."&interval=daily&time_period=10&series_type=close&apikey=NI9JHOEVZJ0M2LC4&outputsize=full";
        $contents_chart = file_get_contents($json_url_ema); 
        $contents_chart = utf8_encode($contents_chart); 
        $json_result_ema = json_decode($contents_chart,true);
        echo json_encode($json_result_ema,JSON_FORCE_OBJECT);   
    }
    else if(isset($_GET['rsi'])) { // chart
        $rsi = $_GET['rsi']; // url : http://localhost/hw8/server.php/?chart=aapl
        $json_url_rsi = "https://www.alphavantage.co/query?function=RSI&symbol=".$rsi."&interval=daily&time_period=10&series_type=close&apikey=NI9JHOEVZJ0M2LC4&outputsize=full";
        $contents_chart = file_get_contents($json_url_rsi); 
        $contents_chart = utf8_encode($contents_chart); 
        $json_result_rsi = json_decode($contents_chart,true);
        echo json_encode($json_result_rsi,JSON_FORCE_OBJECT);   
    }
    else if(isset($_GET['adx'])) { // chart
        $adx = $_GET['adx']; // url : http://localhost/hw8/server.php/?chart=aapl
        $json_url_adx = "https://www.alphavantage.co/query?function=ADX&symbol=".$adx."&interval=daily&time_period=10&series_type=close&apikey=NI9JHOEVZJ0M2LC4&outputsize=full";
        $contents_chart = file_get_contents($json_url_adx); 
        $contents_chart = utf8_encode($contents_chart); 
        $json_result_adx = json_decode($contents_chart,true);
        echo json_encode($json_result_adx,JSON_FORCE_OBJECT);   
    }
    else if(isset($_GET['cci'])) { // chart
        $cci = $_GET['cci']; // url : http://localhost/hw8/server.php/?chart=aapl
        $json_url_cci = "https://www.alphavantage.co/query?function=CCI&symbol=".$cci."&interval=daily&time_period=10&series_type=close&apikey=NI9JHOEVZJ0M2LC4&outputsize=full";
        $contents_chart = file_get_contents($json_url_cci); 
        $contents_chart = utf8_encode($contents_chart); 
        $json_result_cci = json_decode($contents_chart,true);
        echo json_encode($json_result_cci,JSON_FORCE_OBJECT);   
    }
    else if(isset($_GET['stoch'])) { // chart
        $stoch = $_GET['stoch']; // url : http://localhost/hw8/server.php/?chart=aapl
        $json_url_stoch = "https://www.alphavantage.co/query?function=STOCH&symbol=".$stoch."&interval=daily&time_period=10&series_type=close&apikey=NI9JHOEVZJ0M2LC4&outputsize=full";
        $contents_chart = file_get_contents($json_url_stoch); 
        $contents_chart = utf8_encode($contents_chart); 
        $json_result_stoch = json_decode($contents_chart,true);
        echo json_encode($json_result_stoch,JSON_FORCE_OBJECT);   
    }
    else if(isset($_GET['bbands'])) { // chart
        $bbands = $_GET['bbands']; // url : http://localhost/hw8/server.php/?chart=aapl
        $json_url_bbands = "https://www.alphavantage.co/query?function=BBANDS&symbol=".$bbands."&interval=daily&time_period=10&series_type=close&apikey=NI9JHOEVZJ0M2LC4&outputsize=full";
        $contents_chart = file_get_contents($json_url_bbands); 
        $contents_chart = utf8_encode($contents_chart); 
        $json_result_bbands = json_decode($contents_chart,true);
        echo json_encode($json_result_bbands,JSON_FORCE_OBJECT);   
    }
    else if(isset($_GET['macd'])) { // chart
        $macd = $_GET['macd']; // url : http://localhost/hw8/server.php/?chart=aapl
        $json_url_macd = "https://www.alphavantage.co/query?function=MACD&symbol=".$macd."&interval=daily&time_period=10&series_type=close&apikey=NI9JHOEVZJ0M2LC4&outputsize=full";
        $contents_chart = file_get_contents($json_url_macd); 
        $contents_chart = utf8_encode($contents_chart); 
        $json_result_macd = json_decode($contents_chart,true);
        echo json_encode($json_result_macd,JSON_FORCE_OBJECT);   
    }
    else if(isset($_GET['price'])) { // chart
        $price = $_GET['price']; // url : http://localhost/hw8/server.php/?chart=aapl
        $json_url_price = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=".$price."&apikey=T9B64Y0EZDLS1SKT&outputsize=full";
        $contents_chart = file_get_contents($json_url_price); 
        $contents_chart = utf8_encode($contents_chart); 
        $json_result_price = json_decode($contents_chart,true);
        echo json_encode($json_result_price,JSON_FORCE_OBJECT);   
    }
?>