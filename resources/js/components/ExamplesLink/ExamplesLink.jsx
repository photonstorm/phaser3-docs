import React, { useEffect, useState } from 'react';

const calculateMatchPercentage = (wordMap, terms) =>
{
    var totalWords = 0,
        matchedWords = 0,
        percent;

    for (var i in wordMap)
    {
        totalWords += wordMap[i];
        terms.forEach(function (term)
        {
            term = term.toLowerCase();
            if (i === term)
            {
                matchedWords += wordMap[i];
            }
        });
    }

    percent = (matchedWords / totalWords) * 100;
    return parseFloat(percent.toFixed(2));
}

const countMatches = (wordMap, terms) =>
{
    var count = 0;

    for (var i in wordMap)
    {
        terms.forEach(function (term)
        {
            term = term.toLowerCase();
            if (i === term)
            {
                count += wordMap[i];
            }
        });
    }

    return count;
}

const matchSection = (wordMap, terms) =>
{
    var match = {
        fullMatches: countMatches(wordMap, terms),
        percentMatched: calculateMatchPercentage(wordMap, terms)
    };

    return match;
}

const scoreDocument = (match) =>
{

    var score = 0;

    // title percents are usually high if matched, and that's a good test of relevancy so we'll include
    // the percent directly as relevancy points
    score += match.title.percentMatched;

    // body match percentages are likely to be low since the body will contain tons of words usually.
    // we'll weight them a bit higher so this metric isn't totally overshadowed by body match count or title
    // percentages
    score += match.body.percentMatched * 10;

    //full match count in the body will be the base unit
    score += match.body.fullMatches;

    return Math.floor(score);
}

const matchDocument = (document, terms) =>
{
    return {
        body: matchSection(document.bodyWords, terms),
        title: matchSection(document.titleWords, terms)
    };
}

const searchDocuments = (query, data) =>
{
    const index = data;
    var terms = query.split(/[-\[\],:<>+*=;{}'().\s\d/\\]+/);

    var results = [];
    for (var i in index)
    {
        var match = matchDocument(index[i], terms);
        var score = scoreDocument(match);
        const name = index[i].name;
        results.push({
            path: i,
            score: score,
            name
        });
    }

    results.sort(function (a, b)
    {
        var y = a.score;
        var x = b.score;
        return ((x < y) ? -1 : ((x > y) ? 1 : 0));
    });

    results = results.filter(function (item)
    {
        return item.score > 0;
    });

    return results;
}


export const ExamplesLink = (props) =>
{
    const testToSearch = props.titleToSearch.split(".");
    const lastSearch = testToSearch[testToSearch.length - 1];

    const [searchData, setSearchData] = useState([]);

    useEffect(() =>
    {
        fetch("https://labs.phaser.io/documentIndex.json")
            .then(response => response.json())
            .then(data =>
            {
                var results = searchDocuments(lastSearch, data).slice(0, props.quantity ?? 8);
                setSearchData(results);
            });
    }, []);

    return (
        <div className="w-100 border-bottom">
            <div className="d-flex justify-content-center flex-wrap">
                {searchData.map((item, index) =>
                {
                    return (
                        <div className={"m-3"} key={index}>
                            <a href={`https://labs.phaser.io/view.html?src=src/${item.path}`} target="_blank">
                                <div className="text-center d-flex flex-column">
                                    <div>
                                        <img width="150" src={`https://labs.phaser.io/screenshots/${item.path.replace(/\.js|\.ts/, ".png")}`} alt="" />
                                    </div>
                                    <div style={{ marginTop: "-5px" }}>
                                        {item.name.replace(/\.js|\.ts/, "")}
                                    </div>
                                </div>
                            </a>
                        </div>
                    )
                })}

            </div>
        </div>
    );
}
